<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite('resources/css/app.css')
    <title>Marketplace</title>
    <style>
    .hidden {
        display: none;
    }

    #main-content {
        margin-left: 20%;
        transition: margin-left 0.3s ease;
    }

    #sidebar.hidden+#main-content {
        margin-left: 0;
    }
    </style>
</head>

<body>
    <div class="flex h-screen bg-gray-100">
        @include('layout.sidebar')
        <div id="main-content" class="flex flex-col w-full">
            @include('layout.navbar')
            <main class="flex-1 bg-white p-4">
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    @stack('scripts')
</body>

</html>