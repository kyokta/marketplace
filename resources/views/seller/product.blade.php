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
                <td class="py-2">{{ $item->name }}</td>
                <td class="py-2">{{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="py-2">{{ $item->stock }}</td>
                <td class="py-2">
                    <a href="#" class="text-blue-600 hover:text-blue-800 btnEditProduct"
                        data-id="{{ $item->id}} ">Edit</a>
                    |
                    <form action="{{ route('seller.deleteProduct', $item->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="text-red-600 hover:text-red-800 deleteBtn"
                            data-id="{{ $item->id }}">
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
            <button class="closeModal text-gray-500 hover:text-gray-800">
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
                <button type="button"
                    class="closeModal bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Cancel
                </button>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Add Product
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Product Modal -->
<div id="editProductModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 items-center justify-center hidden">
    <div class="bg-white w-2/3 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center pb-3">
            <h3 class="text-lg font-bold">Edit Product</h3>
            <button class="closeModal text-gray-500 hover:text-gray-800">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <form id="formEditProduct" action="" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
            @csrf
            @method('PUT')
            <input type="hidden" id="editProductId" name="productId">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <div class="mb-4">
                        <label for="editProductName" class="block text-sm font-bold mb-2">Product Name:</label>
                        <input type="text" id="editProductName" name="productName"
                            class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <label for="editProductCategory" class="block text-sm font-bold mb-2">Categories:</label>
                        <select id="editProductCategory" name="productCategory" class="w-full px-3 py-2 border rounded">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="editProductPrice" class="block text-sm font-bold mb-2">Price:</label>
                        <input type="number" id="editProductPrice" name="productPrice"
                            class="w-full px-3 py-2 border rounded">
                    </div>
                    <div class="mb-4">
                        <label for="editProductStock" class="block text-sm font-bold mb-2">Stock:</label>
                        <input type="number" id="editProductStock" name="productStock"
                            class="w-full px-3 py-2 border rounded">
                    </div>
                </div>
                <div class="flex-1">
                    <div id="editProductImagePreviewWrapper" class="mb-4 hidden">
                        <label class="block text-sm font-bold mb-2">Current Image:</label>
                        <div class="w-32 h-32 border border-gray-300 rounded overflow-hidden">
                            <img id="editProductImagePreview" src="" class="w-full h-full object-cover"
                                alt="Product Image">
                        </div>
                        <button id="editProductImageRemoveBtn"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mt-2">
                            Remove Image
                        </button>
                    </div>
                    <div class="mb-4">
                        <label for="editProductImage" class="block text-sm font-bold mb-2">Product Image:</label>
                        <input type="file" id="editProductImage" name="productImage"
                            class="w-full px-3 py-2 border rounded">
                    </div>
                    <input type="hidden" id="editProductImageRemove" name="removeImage" value="false">
                    <div class="mb-4">
                        <label for="editProductDescription" class="block text-sm font-bold mb-2">Description:</label>
                        <textarea id="editProductDescription" name="productDescription"
                            class="w-full px-3 py-2 border rounded" rows="4"
                            placeholder="Enter product description"></textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button"
                            class="closeModal bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Update Product
                        </button>
                    </div>
                </div>
            </div>
        </form>

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

        $('.closeModal').on('click', function(e) {
            e.preventDefault();
            $('#productModal').addClass('hidden').removeClass('flex');
            $('#editProductModal').addClass('hidden').removeClass('flex');
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

        $('.btnEditProduct').on('click', function(e) {
            e.preventDefault();
            const productId = $(this).data('id');
            const route = `{{ route('seller.detailProduct', ':id') }}`.replace(':id', productId);

            $.ajax({
                url: route,
                type: 'GET',
                success: function(response) {
                    $('#editProductModal').removeClass('hidden').addClass('flex');

                    $('#editProductId').val(response.id);
                    $('#editProductName').val(response.name);
                    $('#editProductCategory').val(response.category_id);
                    $('#editProductPrice').val(response.price);
                    $('#editProductStock').val(response.stock);
                    $('#editProductDescription').val(response.description);

                    if (response.image) {
                        $('#editProductImagePreview').attr('src',
                            `{{ asset('storage') }}/${response.image}`).removeClass(
                            'hidden');
                        $('#editProductImagePreviewWrapper').removeClass('hidden');
                        $('#editProductImageRemove').val(false);
                    } else {
                        $('#editProductImagePreviewWrapper').addClass('hidden');
                        $('#editProductImageRemove').val(true);
                    }

                    $('#formEditProduct').attr('action',
                        `{{ route('seller.updateProduct', ':id') }}`.replace(':id', response
                            .id));
                },
                error: function(xhr) {
                    Swal.fire(
                        'Failed!',
                        'There was an issue retrieving the product data.',
                        'error'
                    );
                }
            });
        });

        $('#editProductImageRemoveBtn').on('click', function(e) {
            e.preventDefault();
            $('#editProductImagePreviewWrapper').addClass('hidden');
            $('#editProductImageRemove').val(true);
        });

        $('#formEditProduct').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const formData = new FormData(this);

            $.ajax({
                url: form.attr('action') || `{{ route('seller.updateProduct', ['id' => ':id']) }}`
                    .replace(':id', $('#editProductId').val()),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Product updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload()
                    });
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'There was an issue updating the product.';

                    if (errors) {
                        errorMessage = Object.values(errors).flat().join('<br>');
                    }

                    Swal.fire({
                        title: 'Error!',
                        html: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
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