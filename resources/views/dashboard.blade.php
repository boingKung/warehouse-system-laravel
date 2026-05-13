<x-app-layout>
    <x-slot name="header">
        System Overview
    </x-slot>

    <!-- กล่องแสดงตัวเลขสรุป -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white border border-gray-200 p-6 rounded-sm">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Warehouses</h3>
            <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalWarehouses }}</p>
        </div>

        <div class="bg-white border border-gray-200 p-6 rounded-sm">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Products</h3>
            <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalProducts }}</p>
        </div>

        <div class="bg-white border border-gray-200 p-6 rounded-sm">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Transactions</h3>
            <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalTransactions }}</p>
        </div>
    </div>

    <!-- พื้นที่สำหรับแสดงตารางความเคลื่อนไหวในอนาคต -->
    <div class="bg-white border border-gray-200 rounded-sm p-6">
        <h3 class="text-base font-semibold text-gray-900 mb-4">Recent Activity</h3>
        <p class="text-sm text-gray-500">No recent transactions found.</p>
    </div>
</x-app-layout>