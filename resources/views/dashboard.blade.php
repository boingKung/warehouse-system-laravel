<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-6 border-b border-gray-300 pb-4">
            <h1 class="text-2xl font-bold text-gray-900">System Dashboard</h1>
        </div>

        <!-- Section 1: Overall Overview -->
        <h2 class="text-lg font-semibold text-gray-700 mb-4 uppercase tracking-wide">Overall Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-10">
            <div class="bg-white border border-gray-300 p-5">
                <p class="text-sm font-medium text-gray-500">Total Products (SKUs)</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($totalProducts) }}</p>
            </div>
            <div class="bg-white border border-gray-300 p-5">
                <p class="text-sm font-medium text-gray-500">Total Items in Stock</p>
                <p class="mt-2 text-3xl font-bold text-blue-600">{{ number_format($totalStock) }}</p>
            </div>
            <div class="bg-white border border-gray-300 p-5">
                <p class="text-sm font-medium text-gray-500">Today's IN Transactions</p>
                <p class="mt-2 text-3xl font-bold text-green-600">{{ number_format($todayIn) }}</p>
            </div>
            <div class="bg-white border border-gray-300 p-5">
                <p class="text-sm font-medium text-gray-500">Today's OUT Transactions</p>
                <p class="mt-2 text-3xl font-bold text-red-600">{{ number_format($todayOut) }}</p>
            </div>
        </div>

        <!-- Section 2: Per-Warehouse Overview -->
        <h2 class="text-lg font-semibold text-gray-700 mb-4 uppercase tracking-wide">Warehouse Status</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
            @foreach($warehouses as $warehouse)
            <div class="bg-white border border-gray-300 p-5 hover:bg-gray-50 transition">
                <div class="flex justify-between items-center mb-3 border-b border-gray-200 pb-2">
                    <h3 class="text-base font-bold text-gray-900">{{ $warehouse->name }}</h3>
                </div>
                <div class="flex justify-between text-sm mt-2">
                    <span class="text-gray-600">Total Items:</span>
                    <span class="font-semibold text-gray-900">{{ number_format($warehouse->total_items ?? 0) }}</span>
                </div>
                <div class="flex justify-between text-sm mt-1">
                    <span class="text-gray-600">Unique Products:</span>
                    <span class="font-semibold text-gray-900">{{ number_format($warehouse->unique_products) }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Section 3: Recent Transactions -->
        <h2 class="text-lg font-semibold text-gray-700 mb-4 uppercase tracking-wide">Recent Transactions</h2>
        <div class="bg-white border border-gray-300 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">From / To Warehouse</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-800">
                    @foreach($recentTransactions as $tx)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold {{ $tx->type === 'IN' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $tx->type }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($tx->type === 'IN')
                                <span class="text-gray-500">To:</span> {{ $tx->toWarehouse->name ?? '-' }}
                            @else
                                <span class="text-gray-500">From:</span> {{ $tx->fromWarehouse->name ?? '-' }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $tx->employee->name ?? 'Unknown' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2 py-1 bg-gray-200 text-gray-700 text-xs font-bold border border-gray-400">
                                {{ $tx->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>