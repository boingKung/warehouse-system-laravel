<x-app-layout>
    <x-slot name="header">เพิ่มพนักงานใหม่</x-slot>

    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('employees.store') }}" method="POST" class="p-6">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">รหัสพนักงาน</label>
                <input type="text" name="code" value="{{ old('code') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 uppercase" placeholder="เช่น EMP001">
                @error('code')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">ชื่อ-นามสกุล</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="ชื่อพนักงาน">
                @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="flex items-center justify-end gap-4 border-t pt-6">
                <a href="{{ route('employees.index') }}" class="text-sm text-gray-600 hover:text-gray-900">ยกเลิก</a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">บันทึกพนักงาน</button>
            </div>
        </form>
    </div>
</x-app-layout>