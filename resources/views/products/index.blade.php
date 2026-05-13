<x-app-layout>
    <x-slot name="header">
        จัดการสินค้า (Products)
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">รายการสินค้าทั้งหมด</h3>
            <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                + เพิ่มสินค้า
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">รหัสสินค้า (SKU)</th>
                        <th class="px-6 py-3 font-medium">ชื่อสินค้า (Name)</th>
                        <th class="px-6 py-3 font-medium">การควบคุมติดตาม</th>
                        <th class="px-6 py-3 font-medium text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-blue-600">{{ $product->sku }}</td>
                            <td class="px-6 py-4">{{ $product->name }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                @if($product->has_batch)
                                    <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs font-medium">Batch</span>
                                @endif
                                @if($product->has_serial)
                                    <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded text-xs font-medium">Serial</span>
                                @endif
                                @if(!$product->has_batch && !$product->has_serial)
                                    <span class="text-gray-400 text-xs">ทั่วไป</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('products.edit', $product->id) }}" class="text-amber-500 hover:text-amber-700 font-medium mr-3">แก้ไข</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('ยืนยันการลบสินค้านี้?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">ลบ</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                <p>ยังไม่มีข้อมูลสินค้า</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>