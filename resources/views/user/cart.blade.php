@extends('user.layout')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Shopping Cart</h1>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">
                        <input type="checkbox" id="select-all" class="form-checkbox">
                    </th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Price (IDR)</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Total (IDR)</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($carts as $cart)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="checkbox" class="item-checkbox">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <img src="{{ $cart->product->image ? Storage::url($cart->product->image) : asset('https://via.placeholder.com/300x300?text=No+Image+Available') }}"
                            class="mx-auto w-24 h-24">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $cart->product->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <input type="number" min="1" value="{{ $cart->quantity }}"
                            class="w-16 border rounded px-2 py-1 text-center quantity-input" data-id="{{ $cart->id }}"
                            data-price="{{ $cart->product->price }}">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        {{ number_format($cart->product->price, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span
                            id="total-{{ $cart->id }}">{{ number_format($cart->quantity * $cart->product->price, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <button class="deleteCartItem text-red-600 hover:text-red-800" data-id="{{ $cart->id }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end p-4 bg-gray-100">
            <div class="text-lg font-bold">Total (IDR): <span
                    id="cartTotal">{{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="mt-4 flex justify-end">
        <button id="checkoutButton"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:bg-gray-400 disabled:cursor-not-allowed"
            disabled>
            Proceed to Checkout
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function updateTotal() {
        let grandTotal = 0;

        $('.quantity-input').each(function() {
            const quantity = parseInt($(this).val());
            const price = parseInt($(this).data('price'));
            const cartId = $(this).data('id');
            const total = quantity * price;

            $(`#total-${cartId}`).text(total.toLocaleString('id-ID'));

            grandTotal += total;
        });

        $('#cartTotal').text(grandTotal.toLocaleString('id-ID'));
    }

    function toggleCheckoutButton() {
        if ($('.item-checkbox:checked').length > 0) {
            $('#checkoutButton').prop('disabled', false);
        } else {
            $('#checkoutButton').prop('disabled', true);
        }
    }

    $('.quantity-input').on('input', function() {
        updateTotal();
    });

    $('#select-all').on('change', function() {
        $('.item-checkbox').prop('checked', $(this).prop('checked'));
        toggleCheckoutButton();
    });

    $('.item-checkbox').on('change', function() {
        toggleCheckoutButton();
    });

    $('.deleteCartItem').on('click', function() {
        const cartId = $(this).data('id');

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
                    url: `/cart/${cartId}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                'Your item has been deleted.',
                                'success'
                            );
                            location.reload();
                        } else {
                            Swal.fire(
                                'Failed!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Failed!',
                            'There was an error deleting the item.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    $('#checkoutButton').on('click', function(event) {
        event.preventDefault();

        let selectedItems = [];
        $('.item-checkbox:checked').each(function() {
            let cartId = $(this).closest('tr').find('.quantity-input').data('id');
            selectedItems.push(cartId);
        });

        if (selectedItems.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No items selected for checkout!',
            });
            return;
        }

        $.ajax({
            url: '/history/',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                cartIds: selectedItems,
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire(
                        'Success!',
                        'Checkout successful!',
                        'success'
                    ).then(() => {
                        location.reload()
                    });
                } else {
                    Swal.fire(
                        'Failed!',
                        response.message,
                        'error'
                    );
                }
            },
            error: function(xhr) {
                Swal.fire(
                    'Failed!',
                    'There was an error processing the checkout.',
                    'error'
                );
            }
        });
    });

});
</script>
@endpush