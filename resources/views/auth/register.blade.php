@extends('auth.layout')

@section('content')
<div class="flex items-center justify-center h-full w-full bg-gray-100">
    <div class="w-full max-w-md max-h-[60%] bg-white p-8 rounded-lg shadow-md overflow-auto">
        <h1 class="text-3xl font-bold mb-6 text-center">Register</h1>
        <form action="{{ route('register.store') }}" method="POST" class="overflow-auto">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Full Name</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="name" type="text" placeholder="Enter your full name" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="email" type="email" placeholder="Enter your email" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="address">Address</label>
                <textarea
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="address" rows="3" placeholder="Enter your address" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Phone Number</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="phone" type="tel" placeholder="Enter your phone number" type="numeric" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    name="password" type="password" placeholder="Enter your password" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">Confirm
                    Password</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    name="password_confirmation" type="password" placeholder="Confirm your password" required>
            </div>

            <div class="flex items-center justify-center">
                <button
                    class="w-full bg-gray-700 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-xl focus:outline-none focus:shadow-outline"
                    type="submit">
                    Register
                </button>
            </div>

            <div class="mt-4 text-center">
                <p class="text-gray-600 text-sm">Already have an account?
                    <a href="/" class="text-gray-800 font-bold hover:underline">Login</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection