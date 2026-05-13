<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required|string|max:50|unique:products,sku',
            'name' => 'required|string|max:255',
        ], [
            'sku.required' => 'กรุณาระบุรหัส SKU',
            'sku.unique' => 'รหัส SKU นี้มีในระบบแล้ว',
            'name.required' => 'กรุณาระบุชื่อสินค้า',
        ]);

        Product::create([
            'sku' => strtoupper($request->sku),
            'name' => $request->name,
            'has_batch' => $request->has('has_batch'),
            'has_serial' => $request->has('has_serial'),
        ]);

        return redirect()->route('products.index')->with('success', 'เพิ่มข้อมูลสินค้าเรียบร้อยแล้ว');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
        ], [
            'sku.required' => 'กรุณาระบุรหัส SKU',
            'sku.unique' => 'รหัส SKU นี้มีในระบบแล้ว',
            'name.required' => 'กรุณาระบุชื่อสินค้า',
        ]);

        $product->update([
            'sku' => strtoupper($request->sku),
            'name' => $request->name,
            'has_batch' => $request->has('has_batch'),
            'has_serial' => $request->has('has_serial'),
        ]);

        return redirect()->route('products.index')->with('success', 'อัปเดตข้อมูลสินค้าเรียบร้อยแล้ว');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'ลบสินค้าออกจากระบบเรียบร้อยแล้ว');
    }
}