<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Employee;
use App\Models\InventorySummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductBatch;
use App\Models\ItemSerial;

class TransactionController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลรายการพร้อมความสัมพันธ์ (Eager Loading) เพื่อลดภาระฐานข้อมูล
        $transactions = Transaction::with(['employee', 'fromWarehouse', 'toWarehouse'])->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $warehouses = Warehouse::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $employees = Employee::orderBy('name')->get();
        
        // ดึง Batch และ Serial เพื่อไปแสดงใน Dropdown
        $batches = ProductBatch::orderBy('batch_number')->get();
        $serials = ItemSerial::where('status', 'AVAILABLE')->get();

        return view('transactions.create', compact('warehouses', 'products', 'employees', 'batches', 'serials'));
    }

    public function store(Request $request)
{
    $request->validate([
        'type' => 'required|in:IN,OUT',
        'employee_id' => 'required|exists:employees,id',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'to_warehouse_id' => 'required_if:type,IN|nullable|exists:warehouses,id',
        'from_warehouse_id' => 'required_if:type,OUT|nullable|exists:warehouses,id',
    ]);

    $product = Product::find($request->product_id);

    DB::beginTransaction();
    try {
        // 1. สร้างหัวเอกสาร Transaction
        $transaction = Transaction::create([
            'type' => $request->type,
            'status' => 'COMPLETED',
            'employee_id' => $request->employee_id,
            'from_warehouse_id' => $request->type === 'OUT' ? $request->from_warehouse_id : null,
            'to_warehouse_id' => $request->type === 'IN' ? $request->to_warehouse_id : null,
        ]);

        $batchId = null;

        // 2. จัดการข้อมูลอัตโนมัติ เฉพาะกรณี รับเข้า (IN)
        if ($request->type === 'IN') {
            // กรณีมี Batch: สร้าง Batch อัตโนมัติ (ใช้เวลาปัจจุบันมาเจนเลข)
            if ($product->has_batch) {
                $newBatch = ProductBatch::create([
                    'batch_number' => 'BCH-' . $product->sku . '-' . now()->format('YmdHis'),
                    'product_id' => $product->id,
                    'exp_date' => now()->addYear(), // ตั้งค่าเริ่มต้นล่วงหน้า 1 ปี
                ]);
                $batchId = $newBatch->id;
            }

            // กรณีมี Serial: วนลูปสร้าง Serial อัตโนมัติตามจำนวน (Quantity)
            if ($product->has_serial) {
                for ($i = 1; $i <= $request->quantity; $i++) {
                    $serial = ItemSerial::create([
                        'serial_number' => 'SN-' . $product->sku . '-' . now()->format('YmdHis') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                        'product_id' => $product->id,
                        'batch_id' => $batchId,
                        'warehouse_id' => $request->to_warehouse_id,
                        'status' => 'AVAILABLE',
                    ]);

                    // สร้าง Detail แยกราย Serial
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $product->id,
                        'batch_id' => $batchId,
                        'serial_id' => $serial->id,
                        'quantity' => 1,
                    ]);
                }
            } else {
                // กรณีไม่มี Serial แต่มีหรือไม่มี Batch (บันทึกบรรทัดเดียวตามจำนวน)
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'batch_id' => $batchId,
                    'quantity' => $request->quantity,
                ]);
            }

            // อัปเดตสต๊อกรวม
            $inventory = InventorySummary::firstOrCreate(
                ['product_id' => $product->id, 'warehouse_id' => $request->to_warehouse_id, 'batch_id' => $batchId],
                ['quantity' => 0]
            );
            $inventory->increment('quantity', $request->quantity);

        }else {
            // --- กรณี จ่ายออก (OUT) ---
            
            // 1. ตรวจสอบว่ามีสินค้าในคลังนั้นจริงๆ ไหม
            $inventory = InventorySummary::where('product_id', $product->id)
                ->where('warehouse_id', $request->from_warehouse_id)
                ->where('quantity', '>=', $request->quantity)
                ->first();

            if (!$inventory) {
                throw new \Exception('สินค้าในคลังนี้มีไม่เพียงพอสำหรับการจ่ายออก');
            }

            if ($product->has_serial) {
                // กรณีมี Serial: ไปดึง Serial ที่อยู่ในคลังนี้และสถานะเป็น AVAILABLE มาตามจำนวนที่สั่งจ่าย
                $serialsToOut = ItemSerial::where('product_id', $product->id)
                    ->where('warehouse_id', $request->from_warehouse_id)
                    ->where('status', 'AVAILABLE')
                    ->limit($request->quantity)
                    ->get();

                if ($serialsToOut->count() < $request->quantity) {
                    throw new \Exception('จำนวน Serial ที่พร้อมใช้งานในคลังนี้มีไม่เพียงพอ');
                }

                foreach ($serialsToOut as $serial) {
                    // สร้าง Detail รายตัวตาม Serial
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $product->id,
                        'batch_id' => $serial->batch_id,
                        'serial_id' => $serial->id,
                        'quantity' => 1,
                    ]);

                    // อัปเดตสถานะ Serial เป็น SOLD (หรือจะตั้งเป็น OUT ก็ได้)
                    $serial->update(['status' => 'SOLD']);
                }
            } else {
                // กรณีไม่มี Serial (สินค้าทั่วไป หรือมีแค่ Batch)
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'batch_id' => $inventory->batch_id,
                    'quantity' => $request->quantity,
                ]);
            }

            // 2. ตัดยอดสต๊อกรวมในคลังนั้น
            $inventory->decrement('quantity', $request->quantity);
        }

        DB::commit();
        // เมื่อสำเร็จ ให้เด้งไปหน้า Show ของ Transaction นั้นๆ
        return redirect()->route('transactions.show', $transaction->id)->with('success', 'บันทึกรายการและเจนข้อมูลอัตโนมัติสำเร็จ');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withInput()->withErrors(['error' => $e->getMessage()]);
    }
    }

    public function show(Transaction $transaction)
    {
        // โหลดข้อมูลความสัมพันธ์ทั้งหมดเพื่อนำไปแสดงผล
        $transaction->load(['employee', 'fromWarehouse', 'toWarehouse', 'details.product', 'details.serial', 'details.batch']);
        return view('transactions.show', compact('transaction'));
    }
}