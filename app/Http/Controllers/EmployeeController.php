<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('code')->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:20|unique:employees,code',
            'name' => 'required|string|max:255',
        ], [
            'code.required' => 'กรุณาระบุรหัสพนักงาน',
            'code.unique' => 'รหัสพนักงานนี้มีในระบบแล้ว',
            'name.required' => 'กรุณาระบุชื่อพนักงาน',
        ]);

        Employee::create([
            'code' => strtoupper($request->code),
            'name' => $request->name,
        ]);

        return redirect()->route('employees.index')->with('success', 'เพิ่มข้อมูลพนักงานเรียบร้อยแล้ว');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'code' => 'required|string|max:20|unique:employees,code,' . $employee->id,
            'name' => 'required|string|max:255',
        ], [
            'code.required' => 'กรุณาระบุรหัสพนักงาน',
            'code.unique' => 'รหัสพนักงานนี้มีในระบบแล้ว',
            'name.required' => 'กรุณาระบุชื่อพนักงาน',
        ]);

        $employee->update([
            'code' => strtoupper($request->code),
            'name' => $request->name,
        ]);

        return redirect()->route('employees.index')->with('success', 'อัปเดตข้อมูลพนักงานเรียบร้อยแล้ว');
    }

    public function destroy(Employee $employee)
    {
        // ตรวจสอบก่อนลบว่าพนักงานเคยทำรายการหรือไม่ (เพื่อป้องกัน Data Integrity)
        if ($employee->transactions()->count() > 0) {
            return back()->withErrors(['error' => 'ไม่สามารถลบได้เนื่องจากพนักงานท่านนี้มีประวัติการทำรายการในระบบ']);
        }

        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'ลบข้อมูลพนักงานเรียบร้อยแล้ว');
    }
}