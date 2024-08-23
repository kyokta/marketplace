@extends('core')

@section('body')
<div class="flex h-screen bg-gray-100">
    <!-- sidebar -->
    <aside id="sidebar" class="h-full w-[20%] bg-gray-800 p-3 text-white absolute">
        <div class="logo-container p-2 flex items-center justify-center">
            <span class="text-xl font-bold">Marketplace</span>
        </div>
        <nav class="px-4 py-2 space-y-2">
            <a href="{{ route('seller.dashboard') }}" class="flex items-center py-2 px-4 rounded-xl hover:bg-gray-700">
                <i class="fas fa-tachometer-alt mr-2"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('seller.product') }}" class="flex items-center py-2 px-4 rounded-xl hover:bg-gray-700">
                <i class="fas fa-box mr-2"></i>
                <span>Product</span>
            </a>
            <a href="{{ route('seller.order') }}" class="flex items-center py-2 px-4 rounded-xl hover:bg-gray-700">
                <i class="fas fa-shopping-cart mr-2"></i>
                <span>Order</span>
            </a>
        </nav>
    </aside>
    <div id="main-content" class="flex flex-col w-full">
        <!-- navbar -->
        <header class="w-full p-3 bg-blue-gray-800 flex items-center justify-between">
            <button class="hover:bg-white p-2 rounded-lg" id="btnSidebar">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>

            <div class="relative">
                <button id="user-menu-button" class="flex items-center focus:outline-none">
                    <span class="mr-2 font-bold text-gray-800 hover:text-gray-400">{{ Auth::user()->name }}</span>
                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center profile-icon p-1">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14c-3.313 0-6 2.687-6 6 0 1.313 1.687 2 3 2h6c1.313 0 3-0.687 3-2 0-3.313-2.687-6-6-6zM12 2a4 4 0 0 1 4 4 4 4 0 0 1-8 0 4 4 0 0 1 4-4z">
                            </path>
                        </svg>
                    </div>
                </button>

                <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20">
                    <form action="{{ route('logout') }}" method="POST" class="block px-4 py-2 hover:bg-gray-300">
                        @csrf
                        <button type="submit" class="w-full text-left text-sm text-gray-700">Logout</button>
                    </form>
                </div>
            </div>
        </header>
        <main class="flex-1 bg-white p-4 overflow-auto">
            @yield('content')
        </main>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#btnSidebar').on('click', function() {
            $('#sidebar').toggleClass('hidden');
        });

        $('#user-menu-button').on('click', function(event) {
            event.stopPropagation();
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