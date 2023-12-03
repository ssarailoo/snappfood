<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.iconify.design/2/2.0.4/iconify.min.js"></script>
    <script
        src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    ></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;
        var pusher = new Pusher('afc0bed18779ad844414', {
            cluster: 'us2',
        });
        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function (data) {
            var icon = document.getElementById('notification-icon');
            icon.style.display = 'inline-block';
            Toastify({
                text: 'New comment needs review!',
                duration: 3000,
                close: true,
                gravity: 'top',
                position: 'center',
                style: {
                    background: 'linear-gradient(to right, #ff9a9e, #fad0c4)'
                },
            }).showToast();
            $.ajax({
                type: 'GET',
                url: '{{route('comments.new')}}',
                success: function (response) {
                    console.log(response);
                    $('#comment-container').html(response);
                },
                error: function (error) {
                    console.error('Error updating comments:', error);
                }
            });


        });

    </script>


    @stack('scripts')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-pink-300">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main class="p-6">
        {{ $slot }}
    </main>
</div>
</body>
</html>
