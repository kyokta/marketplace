@extends('seller.layout')

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
                <th class="w-2/12 py-2">Price (IDR)</th>
                <th class="w-2/12 py-2">Stock</th>
                <th class="w-2/12 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $item)
            <tr class="text-center border-b">
                <td class="py-2">{{ $index + 1 }}</td>
                <td class="py-2">
                    <img src="{{ $item['image'] ? Storage::url($item['image']) : asset('https://via.placeholder.com/300x300?text=No+Image+Available') }}"
                        class="mx-auto w-24 h-24" alt="{{ $item['name'] }}">
                </td>
                <td class="py-2">{{ $item['name'] }}</td>
                <td class="py-2">{{ number_format($item['price'], 0, ',', '.') }}</td>
                <td class="py-2">50</td>
                <td class="py-2">
                    <a href="#" class="text-blue-600 hover:text-blue-800">Edit</a>
                    |
                    <form action="{{ route('seller.deleteProduct', $item['id']) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="text-red-600 hover:text-red-800 deleteBtn"
                            data-id="{{ $item['id'] }}">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Product Modal -->
<div id="productModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 items-center justify-center hidden">
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
        <form id="formAddProduct" action="{{ route('seller.storeProduct') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="productName" class="block text-sm font-bold mb-2">Product Name:</label>
                <input type="text" id="productName" name="productName" class="w-full px-3 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="productCategory" class="block text-sm font-bold mb-2">Categories:</label>
                <select id="productCategory" name="productCategory" class="w-full px-3 py-2 border rounded">
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="productPrice" class="block text-sm font-bold mb-2">Price:</label>
                <input type="number" id="productPrice" name="productPrice" class="w-full px-3 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="productStock" class="block text-sm font-bold mb-2">Stock:</label>
                <input type="number" id="productStock" name="productStock" class="w-full px-3 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="productImage" class="block text-sm font-bold mb-2">Product Image:</label>
                <input type="file" id="productImage" name="productImage" class="w-full px-3 py-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="productDescription" class="block text-sm font-bold mb-2">Description:</label>
                <textarea id="productDescription" name="productDescription" class="w-full px-3 py-2 border rounded"
                    rows="4" placeholder="Enter product description"></textarea>
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

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 items-center justify-center hidden">
    <div class="bg-white w-1/3 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center pb-3">
            <h3 class="text-lg font-bold">Confirm Delete</h3>
            <button id="closeDeleteModal" class="text-gray-500 hover:text-gray-800">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <p>Are you sure you want to delete this product?</p>
        <div class="flex justify-end pt-4">
            <button type="button" id="cancelDeleteBtn"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                Cancel
            </button>
            <button type="button" id="confirmDeleteBtn"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Delete
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let deleteFormAction;

        $('#openModal').on('click', function(e) {
            e.preventDefault();
            $('#productModal').addClass('flex');
            $('#productModal').removeClass('hidden');
        });

        $('#closeModal, #closeModalBtn').on('click', function(e) {
            e.preventDefault();
            $('#productModal').addClass('hidden');
            $('#productModal').removeClass('flex');
        });

        $('#formAddProduct').on('submit', function(e) {
            e.preventDefault();

            let isValid = true;
            const productName = $('#productName').val().trim();
            const productCategory = $('#productCategory').val();
            const productPrice = $('#productPrice').val().trim();
            const productStock = $('#productStock').val().trim();
            const productImage = $('#productImage').val();
            const productDescription = $('#productDescription').val().trim();

            if (productName === '') {
                isValid = false;
                Swal.fire('Validation Error', 'Please enter a product name.', 'error');
            } else if (productCategory === '') {
                isValid = false;
                Swal.fire('Validation Error', 'Please select a category.', 'error');
            } else if (productPrice === '' || productPrice <= 0) {
                isValid = false;
                Swal.fire('Validation Error', 'Please enter a valid price.', 'error');
            } else if (productStock === '' || productStock <= 0) {
                isValid = false;
                Swal.fire('Validation Error', 'Please enter a valid stock quantity.', 'error');
            } else if (productImage === '') {
                isValid = false;
                Swal.fire('Validation Error', 'Please upload a product image.', 'error');
            } else if (productDescription === '') {
                isValid = false;
                Swal.fire('Validation Error', 'Please enter a product description.', 'error');
            }

            if (isValid) {
                const formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Product Added!',
                            text: 'The product has been successfully added.',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Failed!',
                            'There was an issue adding the product.',
                            'error'
                        );
                    }
                });
            }
        });

        $('.deleteBtn').on('click', function(e) {
            e.preventDefault();
            const productId = $(this).data('id');
            deleteFormAction = '{{ route("seller.deleteProduct", ":id") }}'.replace(':id', productId);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteFormAction,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                'The product has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Failed!',
                                'There was an issue deleting the product.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@endpush