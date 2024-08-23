@extends('auth.layout')

@section('content')
<div class="flex items-center justify-center h-full w-full bg-gray-100">
    <div class="w-3/4 max-w-md bg-white p-8 rounded-lg">
        <h1 class="text-3xl font-bold mb-6 text-center">Marketplace</h1>
        @if (session('success'))
        <div class="mb-4 text-center">
            <p class="text-green-500 text-sm">{{ session('success') }}</p>
        </div>
        @endif

        @if (session('error'))
        <div class="mb-4 text-center">
            <p class="text-red-500 text-sm">{{ session('error') }}</p>
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                    id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email">
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                    id="password" type="password" name="password" placeholder="Enter your password">
                @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-center w-full">
                <button
                    class="w-full bg-gray-700 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-xl focus:outline-none focus:shadow-outline"
                    type="submit">
                    Sign In
                </button>
            </div>
            <div class="mt-4 text-center">
                <p class="text-gray-600 text-sm">Don't have an account?
                    <a href="/register" class="text-gray-800 font-bold hover:underline">Register</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection