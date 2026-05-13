<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Warehouse System') }}</title>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <!-- เพิ่ม w-full และใช้ h-screen เพื่อบังคับเต็มจอ 100% -->
    <body class="flex h-screen w-screen overflow-hidden bg-gray-50 font-sans text-gray-800 antialiased">
        
        <!-- Sidebar (แถบเมนูด้านข้าง) -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col h-full">
            <div class="h-16 flex items-center px-6 border-b border-gray-200 font-bold text-lg tracking-wider text-gray-700">
                WMS SYSTEM
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Dashboard</a>
                <a href="{{ route('warehouses.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">Warehouses</a>
                <a href="{{ route('products.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">Products</a>
                <a href="{{ route('transactions.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">Transactions</a>
                <a href="{{ route('employees.index') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">Employees</a>
                
            </nav>
            <div class="p-4 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 text-sm font-medium text-red-600 rounded-md hover:bg-red-50">Log Out</button>
                </form>
            </div>
        </aside>

        <!-- Main Content (พื้นที่เนื้อหาหลัก) -->
        <main class="flex-1 flex flex-col h-full overflow-hidden">
            <!-- Header -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center px-8 justify-between shrink-0">
                <h1 class="text-xl font-semibold text-gray-800">
                    {{ $header ?? 'Dashboard' }}
                </h1>
                <div class="text-sm text-gray-500 pe-4">
                    User: {{ Auth::user()->name }}
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-8 bg-gray-50">
                {{ $slot }}
            </div>
        </main>
    </body>
</html>