@extends('user.layout')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">Order History</h1>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">#12345</td>
                    <td class="px-6 py-4 whitespace-nowrap">2024-08-15</td>
                    <td class="px-6 py-4 whitespace-nowrap">$100.00</td>
                    <td class="px-6 py-4 whitespace-nowrap text-green-500">Completed</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="#" class="text-blue-600 hover:text-blue-800">View Details</a>
                    </td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">#12346</td>
                    <td class="px-6 py-4 whitespace-nowrap">2024-08-20</td>
                    <td class="px-6 py-4 whitespace-nowrap">$75.00</td>
                    <td class="px-6 py-4 whitespace-nowrap text-yellow-500">Pending</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="#" class="text-blue-600 hover:text-blue-800">View Details</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection