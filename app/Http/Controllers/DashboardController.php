<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลจำนวนเพื่อไปแสดงในหน้า Dashboard
        $totalWarehouses = Warehouse::count();
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();

        return view('dashboard', compact('totalWarehouses', 'totalProducts', 'totalTransactions'));
    }
}
