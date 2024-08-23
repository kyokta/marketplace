@extends('user.layout')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Order History</h1>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Order #</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Total (IDR)</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($history as $index => $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-center">MKT0{{ $item->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        {{ date_format(date_create($item->created_at), 'd F Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        {{ number_format($item->total_amount, 0, ',', '.') }}
                    </td>
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

                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <a href="#" class="text-blue-600 hover:text-blue-800 view-details"
                            data-id="{{ $item->id }}">Details Product</a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Order Details Modal -->
<div id="orderDetailsModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex hidden items-center justify-center">
    <div class="bg-white w-2/3 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center pb-3">
            <h3 class="text-lg font-bold">Order Details</h3>
            <button id="closeModal" class="text-gray-500 hover:text-gray-800">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
        <div id="orderDetailsContent">
            <!-- fetch data from ajax -->
        </div>
        <div class="flex justify-end pt-4">
            <button id="closeModalBtn" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Close
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    function openOrderDetailsModal(orderId) {
        $.ajax({
            url: '{{ route("history.detail", ":id") }}'.replace(':id', orderId),
            type: 'GET',
            success: function(response) {
                const checkout = response.checkout;

                $('#orderDetailsContent').html(`
                    <h3 class="text-lg font-bold mb-4">Items in Order</h3>
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="px-4 py-2">Product Name</th>
                                <th class="px-4 py-2">Quantity</th>
                                <th class="px-4 py-2">Price (IDR)</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${checkout.detail_checkouts.map(item => `
                                <tr>
                                    <td class="border px-4 py-2 text-center">${item.product.name}</td>
                                    <td class="border px-4 py-2 text-center">${item.quantity}</td>
                                    <td class="border px-4 py-2 text-center">${item.product.price.toLocaleString('id-ID')}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                    <p class="mt-4 text-right"><strong>Total (IDR): </strong>${checkout.detail_checkouts.reduce((total, item) => total + (item.quantity * item.product.price), 0).toLocaleString('id-ID')}</p>
                `);

                $('#orderDetailsModal').removeClass('hidden');
                $('#orderDetailsModal').addClass('flex');
            },
            error: function(xhr) {
                console.error('Failed to fetch order details:', xhr.responseText);
            }
        });
    }

    $('#closeModal, #closeModalBtn').on('click', function(e) {
        e.preventDefault();
        $('#orderDetailsModal').addClass('hidden');
        $('#orderDetailsModal').removeClass('flex');
    });

    $('.view-details').on('click', function(e) {
        e.preventDefault();
        const orderId = $(this).data('id');
        openOrderDetailsModal(orderId);
    });
});
</script>
@endpush