@extends('core')

@section('body')
<header class="fixed top-0 left-0 w-full bg-gray-800 text-white flex items-center justify-between py-4 px-10 z-50">
    <div class="flex items-center">
        <span class="text-xl font-bold">M-Place</span>
    </div>
    <div class="flex flex-row gap-6">
        <nav class="md:flex space-x-4">
            <a href="{{ route('home.dashboard') }}" class="flex items-center justify-center w-24 h-10 rounded-lg
        {{ request()->routeIs('home.dashboard') ? 'bg-gray-700' : 'bg-gray-800' }} text-white hover:font-bold">
                <i class="fas fa-home text-lg mr-2"></i>
                Home
            </a>
            <a href="{{ route('cart.dashboard') }}" class="flex items-center justify-center w-24 h-10 rounded-lg
        {{ request()->routeIs('cart.dashboard') ? 'bg-gray-700' : 'bg-gray-800' }} text-white hover:font-bold">
                <i class="fas fa-shopping-cart text-lg mr-2"></i>
                Cart
            </a>
            <a href="{{ route('history.dashboard') }}" class="flex items-center justify-center w-24 h-10 rounded-lg
        {{ request()->routeIs('history.dashboard') ? 'bg-gray-700' : 'bg-gray-800' }} text-white hover:font-bold">
                <i class="fas fa-history text-lg mr-2"></i>
                History
            </a>
        </nav>
        <div class="relative flex items-center">
            <button id="user-menu-button" class="flex items-center focus:outline-none">
                <span class="mr-2 font-bold text-white hover:text-gray-400">{{ Auth::user()->name }}</span>
                <div class="w-8 h-8 rounded-full bg-gray-500 flex items-center justify-center profile-icon p-1">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14c-3.313 0-6 2.687-6 6 0 1.313 1.687 2 3 2h6c1.313 0 3-0.687 3-2 0-3.313-2.687-6-6-6zM12 2a4 4 0 0 1 4 4 4 4 0 0 1-8 0 4 4 0 0 1 4-4z">
                        </path>
                    </svg>
                </div>
            </button>

            <div id="user-dropdown" class="hidden absolute right-0 mt-24 w-48 bg-white rounded-md shadow-lg z-20">
                <form action="{{ route('logout') }}" method="POST" class="block px-4 py-2 hover:bg-gray-300">
                    @csrf
                    <button type="submit" class="w-full text-left text-sm text-gray-700">Logout</button>
                </form>
            </div>
        </div>
    </div>
</header>
<main class="pt-24 p-8">
    @yield('content')
</main>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#user-menu-button').on('click', function() {
            $('#user-dropdown').toggleClass('hidden');
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('#user-menu-button, #user-dropdown').length) {
                $('#user-dropdown').addClass('hidden');
            }
        });
    });
</script>
@endpush