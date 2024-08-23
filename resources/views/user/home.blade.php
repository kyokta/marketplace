@extends('user.layout')

@section('content')
<div class="container mx-auto p-4">
    <div class="text-center mb-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Welcome to Our Marketplace</h1>
        <p class="text-lg text-gray-600">Find the best products for your needs. Use the search bar to explore our wide
            range of items.</p>
    </div>
    <form action="{{ route('home.dashboard') }}" method="GET" class="mb-6">
        <div class="flex flex-row gap-2">
            <input type="text" name="search" placeholder="Search products..."
                class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
            <button type="submit"
                class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 focus:outline-none">Search</button>
        </div>
    </form>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $index => $item)
        <div class="bg-white border rounded-lg shadow-md overflow-hidden">
            <img src="{{ $item['image'] ? Storage::url($item['image']) : asset('https://via.placeholder.com/300x300?text=No+Image+Available') }}"
                class="w-full h-48 object-cover">
            <div class=" p-4">
                <h2 class="text-lg font-bold mb-2">{{ $item['name'] }}</h2>
                <p class="text-gray-700 mb-4">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                <a href="#" class="block bg-gray-700 text-white text-center py-2 rounded-lg hover:bg-gray-600 openModal"
                    data-product-id="{{ $item['id'] }}" data-product-name="{{ $item['name'] }}"
                    data-product-image="{{ $item['image'] ? Storage::url($item['image']) : asset('https://via.placeholder.com/300x300?text=No+Image+Available') }}"
                    data-product-category="{{ $item->category->name ?? 'N/A' }}"
                    data-product-seller="{{ $item->seller->name ?? 'N/A' }}" data-product-stock="{{ $item['stock'] }}"
                    data-product-description="{{ $item['description'] }}">
                    View Details
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>


<!-- Detail Product Modal -->
<div id="detailProduct" class="fixed inset-0 bg-gray-800 bg-opacity-75 items-center justify-center hidden z-50">
    <div class="bg-white w-2/3 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center pb-3">
            <h3 class="text-lg font-bold">Detail Product</h3>
            <button class="closeModal text-gray-500 hover:text-gray-800">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <div class="flex flex-col md:flex-row gap-6 items-center">
            <div id="modalProductImageContainer" class="relative w-80 h-80 rounded-xl bg-cover bg-center"
                style="background-image: url('https://via.placeholder.com/300');">
            </div>
            <div class="flex flex-col md:w-1/2 lg:w-2/3">
                <span id="modalProductName" class="text-2xl font-bold mb-2"></span>
                <span id="modalProductCategory" class="text-md text-gray-600 mb-2"></span>
                <span id="modalProductSeller" class="text-md text-gray-600 mb-2"></span>
                <span id="modalProductStock" class="text-md text-gray-600 mb-4"></span>
                <p id="modalProductDescription" class="text-lg text-gray-700 mb-4 text-justify"></p>
                <span class="text-sm text-gray-600 mb-2 font-bold">Quantity :</span>
                <div class="mb-4 flex items-center">
                    <button id="decreaseQuantity"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-l-lg hover:bg-gray-400">
                        -
                    </button>
                    <input type="text" id="productQuantity" min="1"
                        class="w-16 text-center border-t border-b border-gray-300 px-1 py-2" value="1">
                    <button id="increaseQuantity"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-r-lg hover:bg-gray-400">
                        +
                    </button>
                </div>
                <button
                    class="addToCartBtn bg-gray-700 text-white py-2 px-4 rounded-lg hover:bg-gray-600 focus:outline-none mb-4">
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let currentProductId = null;

    $('.openModal').on('click', function(e) {
        e.preventDefault();

        currentProductId = $(this).data('product-id');
        const productName = $(this).data('product-name');
        const productCategory = $(this).data('product-category');
        const productStock = $(this).data('product-stock');
        const productSeller = $(this).data('product-seller');
        const productDescription = $(this).data('product-description');
        const productImage = $(this).data('product-image') || 'https://via.placeholder.com/300';

        $('#modalProductName').text(productName);
        $('#modalProductCategory').text(`Category : ${productCategory}`);
        $('#modalProductSeller').text(`Seller : ${productSeller}`);
        $('#modalProductStock').text(`Stock: ${productStock}`);
        $('#modalProductDescription').text(productDescription);
        $('#modalProductImageContainer').css('background-image', `url(${productImage})`);

        $('#detailProduct').addClass('flex');
        $('#detailProduct').removeClass('hidden');
    });

    $('.closeModal').on('click', function(e) {
        e.preventDefault();
        $('#detailProduct').addClass('hidden');
        $('#detailProduct').removeClass('flex');
    });

    $('#decreaseQuantity').on('click', function() {
        let quantity = parseInt($('#productQuantity').val());
        if (quantity > 1) {
            $('#productQuantity').val(quantity - 1);
        }
    });

    $('#increaseQuantity').on('click', function() {
        let quantity = parseInt($('#productQuantity').val());
        $('#productQuantity').val(quantity + 1);
    });

    $('#detailProduct').on('click', function(e) {
        if ($(e.target).is('#detailProduct')) {
            $(this).addClass('hidden');
        }
    });

    $('.addToCartBtn').on('click', function(e) {
        e.preventDefault();

        if (currentProductId !== null) {
            const quantity = parseInt($('#productQuantity').val());

            $.ajax({
                url: '{{ route("cart.store") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: currentProductId,
                    quantity: quantity
                },
                success: function(response) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: 'Item added to cart!',
                        text: 'The item has been successfully added to your shopping cart.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $('#detailProduct').addClass('hidden');
                        $('#detailProduct').removeClass('flex');
                        $('#productQuantity').val(1);
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: 'Failed to add item to cart!',
                        text: 'There was a problem adding the item to your shopping cart. Please try again.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $('#detailProduct').addClass('hidden');
                        $('#detailProduct').removeClass('flex');
                        $('#productQuantity').val(1);
                    });
                }
            });
        } else {
            Swal.fire({
                position: "center",
                icon: "error",
                title: 'No product selected!',
                text: 'Please select a product to add to your cart.',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
});
</script>
@endpush