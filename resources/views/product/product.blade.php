@extends('layout.index')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Product List</h1>

    <div class="mb-4">
        <a href="#" id="openModal" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Add New Product
        </a>
    </div>

    <table class="min-w-full bg-white">
        <thead>
            <tr class="w-full bg-gray-800 text-white">
                <th class="w-1/12 py-2">No</th>
                <th class="w-2/12 py-2">Photo</th>
                <th class="w-3/12 py-2">Product Name</th>
                <th class="w-2/12 py-2">Price</th>
                <th class="w-2/12 py-2">Stock</th>
                <th class="w-2/12 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center border-b">
                <td class="py-2">1</td>
                <td class="py-2">
                    <img src="https://via.placeholder.com/50" alt="Product A" class="mx-auto w-24 h-24">
                </td>
                <td class="py-2">Product A</td>
                <td class="py-2">$10.00</td>
                <td class="py-2">50</td>
                <td class="py-2">
                    <a href="#" class="text-blue-600 hover:text-blue-800">Edit</a>
                    |
                    <a href="#" class="text-red-600 hover:text-red-800">Delete</a>
                </td>
            </tr>
            <tr class="text-center border-b">
                <td class="py-2">2</td>
                <td class="py-2">
                    <img src="https://via.placeholder.com/50" alt="Product B" class="mx-auto w-24 h-24">
                </td>
                <td class="py-2">Product B</td>
                <td class="py-2">$15.00</td>
                <td class="py-2">30</td>
                <td class="py-2">
                    <a href="#" class="text-blue-600 hover:text-blue-800">Edit</a>
                    |
                    <a href="#" class="text-red-600 hover:text-red-800">Delete</a>
                </td>
            </tr>
            <tr class="text-center border-b">
                <td class="py-2">3</td>
                <td class="py-2">
                    <img src="https://via.placeholder.com/50" alt="Product C" class="mx-auto w-24 h-24">
                </td>
                <td class="py-2">Product C</td>
                <td class="py-2">$20.00</td>
                <td class="py-2">10</td>
                <td class="py-2">
                    <a href="#" class="text-blue-600 hover:text-blue-800">Edit</a>
                    |
                    <a href="#" class="text-red-600 hover:text-red-800">Delete</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="productModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
    <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center pb-3">
            <h3 class="text-lg font-bold">Add New Product</h3>
            <button id="closeModal" class="text-gray-500 hover:text-gray-800">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <form>
            <div class="mb-4">
                <label for="productName" class="block text-sm font-bold mb-2">Product Name:</label>
                <input type="text" id="productName" class="w-full px-3 py-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="productPrice" class="block text-sm font-bold mb-2">Price:</label>
                <input type="number" id="productPrice" class="w-full px-3 py-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="productStock" class="block text-sm font-bold mb-2">Stock:</label>
                <input type="number" id="productStock" class="w-full px-3 py-2 border rounded">
            </div>

            <div class="mb-4">
                <label for="productImage" class="block text-sm font-bold mb-2">Product Image:</label>
                <input type="file" id="productImage" class="w-full px-3 py-2 border rounded">
            </div>

            <div class="flex justify-end">
                <button type="button" id="closeModalBtn"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Cancel
                </button>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Add Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#openModal').on('click', function(e) {
        e.preventDefault();
        $('#productModal').removeClass('hidden');
    });

    $('#closeModal, #closeModalBtn').on('click', function(e) {
        e.preventDefault();
        $('#productModal').addClass('hidden');
    });
});
</script>
@endpush