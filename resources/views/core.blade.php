<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite('resources/css/app.css')
    <title>M-Place</title>
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
    @yield('body')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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