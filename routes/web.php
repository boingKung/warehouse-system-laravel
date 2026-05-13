<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return redirect()->route('login');
});

//  กลุ่มหน้าเว็บหลักของระบบคลังสินค้า (ต้องล็อกอินและยืนยันตัวตนก่อนถึงจะเข้าได้)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // เรียกใช้ DashboardController ที่เราเพิ่งสร้าง แทนของเดิม
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // โครงร่าง Route สำหรับเมนูคลังสินค้าของเรา
    Route::resource('warehouses', WarehouseController::class); // จัดการ Route ทั้งหมดของ Warehouse (index, create, store, edit, update, destroy)
    Route::resource('products', ProductController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('employees', EmployeeController::class);
});

// 3. กลุ่มหน้าจัดการโปรไฟล์ส่วนตัว (ของเดิมจาก Breeze เก็บไว้ใช้งานได้เลย)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';