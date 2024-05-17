<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="ie=edge" http-equiv="X-UA-Compatible">
    <meta content="{{ csrf_token() }}" name="csrf-token">
    <link rel="icon" type="image/svg+xml" href="{{ Vite::asset('resources/assets/logo.png') }}" />

    <title>{{ env('APP_NAME', 'BoolBnB') }} - @yield('title') </title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite('resources/js/app.js')

    @yield('css')
</head>

<body>
    <div class="wrapper">


        @include('layouts.partials.header')


        <main class="py-5">
            @yield('content')
        </main>


        @include('layouts.partials.footer')

    </div>

    @auth
        <script>
            const logoutLink = document.getElementById('logout-link');
            const logoutForm = document.getElementById('logout-form');

            logoutLink.addEventListener('click', (e) => {
                e.preventDefault();
                logoutForm.submit();
            });
        </script>
    @endauth
    @yield('modal')
    @yield('modal-msg')
    @yield('js')
</body>

</html>
