<x-app-layout>
    <x-slot name="header">
        สร้างรายการเคลื่อนไหวใหม่ (ระบบอัตโนมัติ)
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-800">รายละเอียดเอกสาร</h3>
            </div>

            <form action="{{ route('transactions.store') }}" method="POST" class="p-6">
                @csrf

                @error('error')
                    <div class="mb-6 rounded-md border-l-4 border-red-500 bg-red-50 p-4 shadow-sm">
                        <p class="font-medium text-red-700">{{ $message }}</p>
                    </div>
                @enderror

                <!-- ส่วนที่ 1: ประเภทและพนักงาน -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">ประเภทรายการ</label>
                        <select name="type" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">-- เลือกประเภท --</option>
                            <option value="IN" {{ old('type') == 'IN' ? 'selected' : '' }}>รับเข้าคลัง (IN)</option>
                            <option value="OUT" {{ old('type') == 'OUT' ? 'selected' : '' }}>จ่ายออกจากคลัง (OUT)</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500 text-blue-600 font-medium">หากเลือก IN ระบบจะเจน Batch/Serial ให้อัตโนมัติ</p>
                        @error('type')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">พนักงานผู้ทำรายการ</label>
                        <select name="employee_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">-- เลือกพนักงาน --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>{{ $emp->code }} - {{ $emp->name }}</option>
                            @endforeach
                        </select>
                        @error('employee_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- ส่วนที่ 2: คลังสินค้า -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 border-t border-gray-100 pt-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">คลังต้นทาง (สำหรับจ่ายออก)</label>
                        <select name="from_warehouse_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- เลือกคลังต้นทาง --</option>
                            @foreach($warehouses as $wh)
                                <option value="{{ $wh->id }}" {{ old('from_warehouse_id') == $wh->id ? 'selected' : '' }}>{{ $wh->name }}</option>
                            @endforeach
                        </select>
                        @error('from_warehouse_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">คลังปลายทาง (สำหรับรับเข้า)</label>
                        <select name="to_warehouse_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- เลือกคลังปลายทาง --</option>
                            @foreach($warehouses as $wh)
                                <option value="{{ $wh->id }}" {{ old('to_warehouse_id') == $wh->id ? 'selected' : '' }}>{{ $wh->name }}</option>
                            @endforeach
                        </select>
                        @error('to_warehouse_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- ส่วนที่ 3: สินค้าและจำนวน -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-100 pt-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">สินค้า</label>
                        <select name="product_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">-- เลือกสินค้า --</option>
                            @foreach($products as $pd)
                                <option value="{{ $pd->id }}" {{ old('product_id') == $pd->id ? 'selected' : '' }}>{{ $pd->sku }} - {{ $pd->name }}</option>
                            @endforeach
                        </select>
                        @error('product_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">จำนวน</label>
                        <input type="number" name="quantity" min="1" value="{{ old('quantity', 1) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        @error('quantity')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- ปุ่มควบคุม -->
                <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6 mt-8">
                    <a href="{{ route('transactions.index') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm transition-colors">
                        ยกเลิก
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                        บันทึกรายการและรันหมายเลข
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>