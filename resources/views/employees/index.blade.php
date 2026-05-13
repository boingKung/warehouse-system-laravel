<x-app-layout>
    <x-slot name="header">จัดการพนักงาน</x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">รายชื่อพนักงานทั้งหมด</h3>
            <a href="{{ route('employees.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                + เพิ่มพนักงาน
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">รหัสพนักงาน</th>
                        <th class="px-6 py-3 font-medium">ชื่อ-นามสกุล</th>
                        <th class="px-6 py-3 font-medium text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                    @forelse($employees as $emp)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-blue-600">{{ $emp->code }}</td>
                            <td class="px-6 py-4">{{ $emp->name }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('employees.edit', $emp->id) }}" class="text-amber-500 hover:text-amber-700 font-medium mr-3">แก้ไข</a>
                                <form action="{{ route('employees.destroy', $emp->id) }}" method="POST" class="inline-block" onsubmit="return confirm('ยืนยันการลบพนักงาน?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">ลบ</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-6 py-12 text-center text-gray-400">ไม่พบข้อมูลพนักงาน</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>