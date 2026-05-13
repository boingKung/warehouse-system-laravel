<x-app-layout>
    <x-slot name="header">
        จัดการคลังสินค้า (Warehouses)
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- แถบด้านบนของตาราง -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">รายการคลังสินค้าทั้งหมด</h3>
            <a href="{{ route('warehouses.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                + เพิ่มคลังสินค้า
            </a>
        </div>

        <!-- ตัวตาราง -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">รหัสคลัง (Code)</th>
                        <th class="px-6 py-3 font-medium">ชื่อคลังสินค้า (Name)</th>
                        <th class="px-6 py-3 font-medium">วันที่เพิ่มข้อมูล</th>
                        <th class="px-6 py-3 font-medium text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                    @forelse($warehouses as $warehouse)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-blue-600">{{ $warehouse->code }}</td>
                            <td class="px-6 py-4">{{ $warehouse->name }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $warehouse->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="text-amber-500 hover:text-amber-700 font-medium mr-3">แก้ไข</a>
                                <!-- ปุ่มลบจะทำเป็น Form ป้องกันการลบโดยไม่ตั้งใจ -->
                                <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" class="inline-block" onsubmit="return confirm('ยืนยันการลบคลังสินค้านี้?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">ลบ</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                <p>ยังไม่มีข้อมูลคลังสินค้า</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>