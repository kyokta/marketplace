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
                <th class="py-2 px-4">Total Amount</th>
                <th class="py-2 px-4">Status</th>
                <th class="py-2 px-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center border-b">
                <td class="py-2 px-2">1</td>
                <td class="py-2 px-4">ORD12345</td>
                <td class="py-2 px-4">Jane Doe</td>
                <td class="py-2 px-4">2024-08-22</td>
                <td class="py-2 px-4">$100.00</td>
                <td class="py-2 px-4 text-green-600">Completed</td>
                <td class="py-2 px-4">
                    <a href="#" class="text-blue-600 hover:text-blue-800">View</a>
                    |
                    <a href="#" class="text-red-600 hover:text-red-800">Delete</a>
                </td>
            </tr>
            <tr class="text-center border-b">
                <td class="py-2 px-2">2</td>
                <td class="py-2 px-4">ORD12346</td>
                <td class="py-2 px-4">John Smith</td>
                <td class="py-2 px-4">2024-08-21</td>
                <td class="py-2 px-4">$150.00</td>
                <td class="py-2 px-4 text-yellow-600">Pending</td>
                <td class="py-2 px-4">
                    <a href="#" class="text-blue-600 hover:text-blue-800">View</a>
                    |
                    <a href="#" class="text-red-600 hover:text-red-800">Delete</a>
                </td>
            </tr>
            <tr class="text-center border-b">
                <td class="py-2 px-2">3</td>
                <td class="py-2 px-4">ORD12347</td>
                <td class="py-2 px-4">Emily Clark</td>
                <td class="py-2 px-4">2024-08-20</td>
                <td class="py-2 px-4">$200.00</td>
                <td class="py-2 px-4 text-red-600">Cancelled</td>
                <td class="py-2 px-4">
                    <a href="#" class="text-blue-600 hover:text-blue-800">View</a>
                    |
                    <a href="#" class="text-red-600 hover:text-red-800">Delete</a>
                </td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
</div>
@endsection