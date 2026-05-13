<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\InventorySummary;
use App\Models\Warehouse;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. ภาพรวมทั้งหมด (Overall Overview)
        $totalProducts = Product::count();
        $totalStock = InventorySummary::sum('quantity');
        
        // นับรายการ Transaction ของวันนี้ แยกรับเข้า-จ่ายออก
        $todayIn = Transaction::where('type', 'IN')->whereDate('created_at', today())->count();
        $todayOut = Transaction::where('type', 'OUT')->whereDate('created_at', today())->count();

        // 2. ภาพรวมรายคลังสินค้า (Per-Warehouse Overview)
        // ใช้ withSum เพื่อรวมยอด quantity จาก InventorySummary ตามคลังสินค้าแต่ละแห่ง
        $warehouses = Warehouse::withSum('inventorySummaries as total_items', 'quantity')
            ->get()
            ->map(function ($warehouse) {
                // หาจำนวนรายการสินค้าที่ไม่ซ้ำกันในคลังนี้ (ที่มีของอยู่)
                $warehouse->unique_products = InventorySummary::where('warehouse_id', $warehouse->id)
                    ->where('quantity', '>', 0)
                    ->distinct('product_id')
                    ->count('product_id');
                return $warehouse;
            });

        // 3. รายการเคลื่อนไหวล่าสุด (อิงตาม TransactionController ที่มี relation employee, fromWarehouse, toWarehouse)
        $recentTransactions = Transaction::with(['employee', 'fromWarehouse', 'toWarehouse'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts', 
            'totalStock', 
            'todayIn', 
            'todayOut', 
            'warehouses', 
            'recentTransactions'
        ));
    }
}