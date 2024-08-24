@extends('seller.layout')

@section('content')
<div class="mx-auto p-4 flex flex-col gap-4">
    <h1 class="text-2xl font-bold">Order List</h1>

    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr class="bg-gray-800 text-white">
                <th class="py-2 px-2">No</th>
                <th class="py-2 px-4">Order Number</th>
                <th class="py-2 px-4">Customer Name</th>
                <th class="py-2 px-4">Order Date</th>
                <th class="py-2 px-4">Total Amount (IDR)</th>
                <th class="py-2 px-4">Status</th>
                <th class="py-2 px-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $item)
            <tr class="text-center border-b">
                <td class="py-2 px-2">{{ $index + 1 }}</td>
                <td class="py-2 px-4">{{ $item->order_id }}</td>
                <td class="py-2 px-4">{{ $item->customer_name }}</td>
                <td class="py-2 px-4">{{ date_format(date_create($item->order_date), 'd F Y') }}</td>
                <td class="py-2 px-4"> {{ number_format($item->total_amount, 0, ',', '.') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    @if($item->status == 'completed')
                    <span class="text-green-500 px-2 py-1 rounded-full text-sm font-medium">Completed</span>
                    @elseif($item->status == 'pending')
                    <span class="text-yellow-500 px-2 py-1 rounded-full text-sm font-medium">Pending</span>
                    @elseif($item->status == 'processed')
                    <span class="text-blue-500 px-2 py-1 rounded-full text-sm font-medium">Processed</span>
                    @elseif($item->status == 'cancelled')
                    <span class="text-red-500 px-2 py-1 rounded-full text-sm font-medium">Cancelled</span>
                    @else
                    <span class="text-gray-500 px-2 py-1 rounded-full text-sm font-medium">Unknown</span>
                    @endif
                </td>
                <td class="py-2 px-4">
                    <a href="#" class="text-blue-600 hover:text-blue-800 view-details"
                        data-order-id="{{ $item->checkout_id }}" data-order-details="{{ json_encode($item) }}">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Detail Order Modal -->
<div id="detailOrderModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 items-center justify-center hidden">
    <div class="bg-white w-1/3 rounded-lg shadow-lg p-6 relative">
        <div class="flex justify-between items-center pb-3">
            <h4 class="text-lg font-bold mb-2">Product Details</h4>
            <button id="closeDetailModal" class="text-gray-500 hover:text-gray-800">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <div id="modalContent" class="mb-4">
            <div class="mb-4">
                <input type="hidden" id="idCheckout">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="py-2 px-4">Product Name</th>
                            <th class="py-2 px-4">Quantity</th>
                            <th class="py-2 px-4">Prize (IDR)</th>
                            <th class="py-2 px-4">Total (IDR)</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        <!-- data from ajax -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Change Status:</label>
            <select id="statusOrder"
                class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="pending">Pending</option>
                <option value="processed">Processed</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <div class="flex justify-end pt-4">
            <button type="button" id="saveChangesBtn"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                Save Changes
            </button>
            <button type="button" id="cancelDetailBtn"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Cancel
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.view-details').on('click', function(e) {
            e.preventDefault();
            var checkoutId = $(this).data('order-id');
            var url = `{{ route('seller.detailOrder', ':id') }}`.replace(':id', checkoutId);

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    var productTableBody = '';
                    $('#statusOrder').val(response.status);
                    $('#idCheckout').val(checkoutId)

                    if (response.status === 'completed') {
                        $('#statusOrder').prop('disabled', true);
                        $('#saveChangesBtn').hide();
                    } else {
                        $('#saveChangesBtn').show();
                    }

                    response.orders.forEach(function(detailOrder) {
                        productTableBody += `
                    <tr class="text-center border-b">
                        <td class="py-2 px-4">${detailOrder.products.name}</td>
                        <td class="py-2 px-4">${detailOrder.quantity}</td>
                        <td class="py-2 px-4">${detailOrder.price}</td>
                        <td class="py-2 px-4">${detailOrder.total_price}</td>
                    </tr>
                `;
                    });

                    $('#productTableBody').html(productTableBody);
                    $('#detailOrderModal').removeClass('hidden').addClass('flex');
                },
                error: function() {
                    alert('Failed to retrieve order details.');
                }
            });
        });


        $('#closeDetailModal, #cancelDetailBtn').on('click', function() {
            $('#detailOrderModal').addClass('hidden');
            $('#detailOrderModal').removeClass('flex');
        });

        $('#saveChangesBtn').on('click', function() {
            var status = $('#statusOrder').val();
            var checkoutId = $('#idCheckout').val();
            var url = `{{ route('seller.updateOrder', ':id') }}`.replace(':id', checkoutId);

            $.ajax({
                url: url,
                method: 'PUT',
                data: {
                    _token: "{{ csrf_token() }}",
                    status: status
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Order status updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#detailOrderModal').addClass('hidden').removeClass('flex');
                        location.reload();
                    });
                },
                error: function(response) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to update status.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
@endpush