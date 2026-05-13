<x-app-layout>
    <x-slot name="header">
        เพิ่มคลังสินค้าใหม่
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-800">ข้อมูลคลังสินค้า</h3>
            </div>

            <form action="{{ route('warehouses.store') }}" method="POST" class="p-6">
                @csrf

                <div class="mb-6">
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">รหัสคลังสินค้า (Code)</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" 
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 uppercase" 
                        placeholder="เช่น WH-01">
                    @error('code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">ชื่อคลังสินค้า (Name)</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                        placeholder="เช่น โกดังสินค้าสำเร็จรูป A">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6 mt-6">
                    <a href="{{ route('warehouses.index') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm transition-colors">
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