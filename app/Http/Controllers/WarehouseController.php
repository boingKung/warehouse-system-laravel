<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // ดึงข้อมูลคลังสินค้าทั้งหมด เรียงจากใหม่ไปเก่า
        $warehouses = Warehouse::latest()->get();
        
        return view('warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        // 1. ตรวจสอบความถูกต้องของข้อมูล (Validation)
        $request->validate([
            'code' => 'required|string|max:50|unique:warehouses,code',
            'name' => 'required|string|max:255',
        ], [
            'code.required' => 'กรุณาระบุรหัสคลังสินค้า',
            'code.unique' => 'รหัสคลังสินค้านี้มีในระบบแล้ว',
            'name.required' => 'กรุณาระบุชื่อคลังสินค้า',
        ]);

        // 2. บันทึกข้อมูลลงฐานข้อมูล
        Warehouse::create([
            'code' => strtoupper($request->code), // บังคับให้รหัสเป็นตัวพิมพ์ใหญ่
            'name' => $request->name,
        ]);

        // 3. ส่งกลับไปหน้าแรกพร้อมข้อความแจ้งเตือน
        return redirect()->route('warehouses.index')->with('success', 'เพิ่มข้อมูลคลังสินค้าเรียบร้อยแล้ว');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Warehouse $warehouse)
    {
        // ส่งข้อมูลคลังสินค้าที่ต้องการแก้ไขไปที่หน้าฟอร์ม
        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        // 1. ตรวจสอบข้อมูล (ตอนแก้ไข ต้องละเว้นการเช็ครหัสซ้ำของตัวมันเองด้วย)
        $request->validate([
            'code' => 'required|string|max:50|unique:warehouses,code,' . $warehouse->id,
            'name' => 'required|string|max:255',
        ], [
            'code.required' => 'กรุณาระบุรหัสคลังสินค้า',
            'code.unique' => 'รหัสคลังสินค้านี้มีในระบบแล้ว',
            'name.required' => 'กรุณาระบุชื่อคลังสินค้า',
        ]);

        // 2. อัปเดตข้อมูลลงฐานข้อมูล
        $warehouse->update([
            'code' => strtoupper($request->code),
            'name' => $request->name,
        ]);

        // 3. กลับไปหน้าแรกพร้อมข้อความแจ้งเตือน
        return redirect()->route('warehouses.index')->with('success', 'อัปเดตข้อมูลคลังสินค้าเรียบร้อยแล้ว');
    }

    public function destroy(Warehouse $warehouse)
    {
        // ลบข้อมูล
        $warehouse->delete();

        // กลับไปหน้าแรกพร้อมข้อความแจ้งเตือน
        return redirect()->route('warehouses.index')->with('success', 'ลบคลังสินค้าออกจากระบบเรียบร้อยแล้ว');
    }
}
