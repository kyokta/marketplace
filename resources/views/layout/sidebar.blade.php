<aside id="sidebar" class="h-full w-[20%] bg-gray-800 p-3 text-white absolute">
    <div class="logo-container p-2 flex items-center justify-center">
        <span class="text-xl font-bold">Marketplace</span>
    </div>
    <nav class="px-4 py-2 space-y-2">
        <a href="{{ route('seller.dashboard') }}" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-tachometer-alt mr-2"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('seller.product') }}" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-box mr-2"></i>
            <span>Product</span>
        </a>
        <a href="{{ route('seller.order') }}" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
            <i class="fas fa-shopping-cart mr-2"></i>
            <span>Order</span>
        </a>
    </nav>
</aside>