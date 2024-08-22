@extends('user.layout')

@section('content')
<div class="container mx-auto p-4">
    <div class="text-center mb-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Welcome to Our Marketplace</h1>
        <p class="text-lg text-gray-600">Find the best products for your needs. Use the search bar to explore our wide
            range of items.</p>
    </div>
    <div class="mb-6">
        <div class="flex flex-row gap-2">
            <input type="text" placeholder="Search products..."
                class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
            <button class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 focus:outline-none">
                Search
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <!-- Product Card 1 -->
        <div class="bg-white border rounded-lg shadow-md overflow-hidden">
            <img src="https://via.placeholder.com/300" alt="Product 1" class="w-full h-48 object-cover">
            <div class="p-4">
                <h2 class="text-lg font-bold mb-2">Product 1</h2>
                <p class="text-gray-700 mb-4">$10.00</p>
                <a href="#" class="block bg-gray-700 text-white text-center py-2 rounded-lg hover:bg-gray-600">
                    View Details
                </a>
            </div>
        </div>

        <!-- Product Card 2 -->
        <div class="bg-white border rounded-lg shadow-md overflow-hidden">
            <img src="https://via.placeholder.com/300" alt="Product 2" class="w-full h-48 object-cover">
            <div class="p-4">
                <h2 class="text-lg font-bold mb-2">Product 2</h2>
                <p class="text-gray-700 mb-4">$15.00</p>
                <a href="#" class="block bg-gray-700 text-white text-center py-2 rounded-lg hover:bg-gray-600">
                    View Details
                </a>
            </div>
        </div>

        <!-- Product Card 3 -->
        <div class="bg-white border rounded-lg shadow-md overflow-hidden">
            <img src="https://via.placeholder.com/300" alt="Product 3" class="w-full h-48 object-cover">
            <div class="p-4">
                <h2 class="text-lg font-bold mb-2">Product 3</h2>
                <p class="text-gray-700 mb-4">$20.00</p>
                <a href="#" class="block bg-gray-700 text-white text-center py-2 rounded-lg hover:bg-gray-600">
                    View Details
                </a>
            </div>
        </div>

        <!-- Product Card 4 -->
        <div class="bg-white border rounded-lg shadow-md overflow-hidden">
            <img src="https://via.placeholder.com/300" alt="Product 4" class="w-full h-48 object-cover">
            <div class="p-4">
                <h2 class="text-lg font-bold mb-2">Product 4</h2>
                <p class="text-gray-700 mb-4">$25.00</p>
                <a href="#" class="block bg-gray-700 text-white text-center py-2 rounded-lg hover:bg-gray-600">
                    View Details
                </a>
            </div>
        </div>
    </div>
</div>
@endsection