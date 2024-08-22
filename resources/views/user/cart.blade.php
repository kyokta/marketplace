@extends('user.layout')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Shopping Cart</h1>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                        <input type="checkbox" id="select-all" class="form-checkbox">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" class="item-checkbox">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="https://via.placeholder.com/50" alt="Product A"
                            class="w-12 h-12 object-cover rounded">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">Product A</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" min="1" value="2" class="w-16 border rounded px-2 py-1 text-center">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">$10.00</td>
                    <td class="px-6 py-4 whitespace-nowrap">$20.00</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="checkbox" class="item-checkbox">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="https://via.placeholder.com/50" alt="Product B"
                            class="w-12 h-12 object-cover rounded">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">Product B</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <input type="number" min="1" value="1" class="w-16 border rounded px-2 py-1 text-center">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">$15.00</td>
                    <td class="px-6 py-4 whitespace-nowrap">$15.00</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex justify-end p-4 bg-gray-100">
            <div class="text-lg font-bold">Total: $35.00</div>
        </div>
    </div>

    <div class="mt-4 flex justify-end">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Proceed to Checkout
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#select-all').on('change', function() {
        $('.item-checkbox').prop('checked', $(this).prop('checked'));
    });
});
</script>
@endpush