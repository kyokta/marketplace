@extends('core')

@section('body')

<div class="h-screen flex flex-col w-full bg-gray-100">
    <div
        class="h-[15%] flex flex-col items-center justify-center bg-gray-300 rounded-b-full fixed top-0 left-0 w-full z-10">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">M-Place</h1>
    </div>

    <div class="w-full h-full">
        @yield('content')
    </div>

    <div
        class="h-[15%] flex flex-col items-center justify-center bg-gray-300 rounded-t-full fixed bottom-0 left-0 w-full z-10">
        <p class="text-lg text-gray-600">Your Gateway to Great Finds</p>
    </div>
</div>

@endsection