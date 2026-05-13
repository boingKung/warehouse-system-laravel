<x-app-layout>
    <x-slot name="header">
        เพิ่มสินค้าใหม่
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-800">ข้อมูลสินค้าพื้นฐาน</h3>
            </div>

            <form action="{{ route('products.store') }}" method="POST" class="p-6">
                @csrf

                <div class="mb-6">
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">รหัสสินค้า (SKU)</label>
                    <input type="text" name="sku" id="sku" value="{{ old('sku') }}" 
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 uppercase" 
                        placeholder="เช่น PRD-001">
                    @error('sku')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">ชื่อสินค้า (Name)</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                        placeholder="ระบุชื่อสินค้า">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 border-t border-gray-100 pt-6">
                    <h4 class="text-sm font-medium text-gray-800 mb-4">การควบคุมและติดตามสินค้า (Tracking)</h4>
                    
                    <div class="flex items-center mb-4">
                        <input id="has_batch" name="has_batch" type="checkbox" value="1" {{ old('has_batch') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="has_batch" class="ms-2 text-sm font-medium text-gray-700">ควบคุมด้วยระบบ Batch / Lot Number (เช่น สินค้ามีวันหมดอายุ)</label>
                    </div>
                    
                    <div class="flex items-center">
                        <input id="has_serial" name="has_serial" type="checkbox" value="1" {{ old('has_serial') ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="has_serial" class="ms-2 text-sm font-medium text-gray-700">ควบคุมด้วยระบบ Serial Number (บันทึกรายชิ้น)</label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6 mt-6">
                    <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm transition-colors">
                        ยกเลิก
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                        บันทึกข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>