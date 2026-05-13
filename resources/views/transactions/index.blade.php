<x-app-layout>
    <x-slot name="header">
        รายการเคลื่อนไหว (Transactions)
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">ประวัติการ รับ / จ่าย / ย้าย</h3>
            <a href="{{ route('transactions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                + สร้างรายการใหม่
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-sm border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">รหัสรายการ (ID)</th>
                        <th class="px-6 py-3 font-medium">ประเภท</th>
                        <th class="px-6 py-3 font-medium">คลังต้นทาง</th>
                        <th class="px-6 py-3 font-medium">คลังปลายทาง</th>
                        <th class="px-6 py-3 font-medium">พนักงาน</th>
                        <th class="px-6 py-3 font-medium">วันที่ทำรายการ</th>
                        <th class="px-6 py-3 font-medium">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-blue-600">TRX-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4">
                                @if($transaction->type === 'IN')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">รับเข้า (IN)</span>
                                @elseif($transaction->type === 'OUT')
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">จ่ายออก (OUT)</span>
                                @else
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">โอนย้าย (TRANSFER)</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $transaction->fromWarehouse->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $transaction->toWarehouse->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $transaction->employee->name ?? 'ไม่ระบุ' }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                            <td class="">
                                <a href="{{ route('transactions.show', $transaction->id) }}" class="inline-flex items-center px-3 py-1 bg-slate-100 text-slate-700 rounded-md hover:bg-slate-200 transition-colors font-medium">
                                    รายละเอียด
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <p>ยังไม่มีประวัติการทำรายการ</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>