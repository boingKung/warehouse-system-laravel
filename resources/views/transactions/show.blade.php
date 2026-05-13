<x-app-layout>
    <x-slot name="header">
        รายละเอียดรายการ: TRX-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        <!-- ข้อมูลหัวเอกสาร -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase mb-1">ประเภทรายการ</p>
                    <p class="text-lg font-bold text-gray-800">
                        {{ $transaction->type === 'IN' ? 'รับเข้าคลัง' : 'จ่ายออกคลัง' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase mb-1">คลังที่ดำเนินการ</p>
                    <p class="text-lg font-bold text-gray-800">
                        {{ $transaction->type === 'IN' ? $transaction->toWarehouse->name : $transaction->fromWarehouse->name }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase mb-1">พนักงานผู้บันทึก</p>
                    <p class="text-lg font-bold text-gray-800">{{ $transaction->employee->name }}</p>
                </div>
            </div>
        </div>

        <!-- รายการสินค้าและข้อมูลที่เจนอัตโนมัติ -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-800">รายการสินค้าและหมายเลขควบคุม</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-100">
                            <th class="px-6 py-3 font-medium">สินค้า</th>
                            <th class="px-6 py-3 font-medium">หมายเลขล็อต (Batch)</th>
                            <th class="px-6 py-3 font-medium">ซีเรียลนัมเบอร์ (Serial)</th>
                            <th class="px-6 py-3 font-medium text-right">จำนวน</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                        @foreach($transaction->details as $detail)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-semibold">{{ $detail->product->sku }}</div>
                                    <div class="text-gray-500">{{ $detail->product->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $detail->batch->batch_number ?? '-' }}
                                </td>
                                <td class="px-6 py-4 font-mono text-xs">
                                    {{ $detail->serial->serial_number ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-right font-bold">
                                    {{ number_format($detail->quantity) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    วันเวลาที่บันทึก: {{ $transaction->created_at->format('d/m/Y H:i:s') }}
                </div>
                <a href="{{ route('transactions.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    กลับสู่รายการทั้งหมด
                </a>
            </div>
        </div>
    </div>
</x-app-layout>