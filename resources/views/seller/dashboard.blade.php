@extends('seller.layout')

@section('content')
<div class="mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Seller Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Sales Card -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold">Total Sales</h2>
            <p class="text-4xl font-bold text-gray-800 mt-4">{{ $data['totalSales'] }}</p>
            <p class="text-sm text-gray-600 mt-2">Total products sold</p>
        </div>

        <!-- Total Revenue Card -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold">Total Revenue</h2>
            <p class="text-4xl font-bold text-gray-800 mt-4">{{ number_format($data['totalRevenue'], 0, ',', '.') }} IDR
            </p>
            <p class="text-sm text-gray-600 mt-2">Total earnings</p>
        </div>

        <!-- Products Listed Card -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold">Products Listed</h2>
            <p class="text-4xl font-bold text-gray-800 mt-4">{{ $data['productListed'] }}</p>
            <p class="text-sm text-gray-600 mt-2">Total products listed</p>
        </div>

        <!-- Pending Orders Card -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold">Pending Orders</h2>
            <p class="text-4xl font-bold text-gray-800 mt-4">{{ $data['pendingOrders'] }}</p>
            <p class="text-sm text-gray-600 mt-2">Orders awaiting processing</p>
        </div>

        <!-- Top Selling Product Card -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold">Top Selling Product</h2>
            <p class="text-4xl font-bold text-gray-800 mt-4">{{ $data['topProduct'] }}</p>
            <p class="text-sm text-gray-600 mt-2">Best performing product</p>
        </div>
    </div>
</div>
@endsection