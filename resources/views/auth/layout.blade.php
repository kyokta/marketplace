@extends('core')

@section('body')

<div class="h-screen flex bg-gray-100">
    <div class="w-1/2 h-full flex items-center justify-center bg-gray-500 rounded-r-2xl">
        <img src="/images/marketplace.png" alt="">
    </div>

    <div class="w-1/2 h-full">
        @yield('content')
    </div>
</div>

@endsection