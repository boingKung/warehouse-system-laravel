<x-app-layout>
    <x-slot name="header">
        แก้ไขข้อมูลพนักงาน: {{ $employee->code }}
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-800">ข้อมูลพนักงาน</h3>
            </div>

            <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">รหัสพนักงาน</label>
                    <input type="text" name="code" value="{{ old('code', $employee->code) }}" 
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 uppercase" 
                        readonly>
                    <p class="mt-1 text-xs text-gray-500">รหัสพนักงานไม่สามารถแก้ไขได้</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">ชื่อ-นามสกุล</label>
                    <input type="text" name="name" value="{{ old('name', $employee->name) }}" 
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                        placeholder="ระบุชื่อพนักงาน">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-4 border-t pt-6">
                    <a href="{{ route('employees.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors">
                        ยกเลิก
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                        อัปเดตข้อมูล
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>