<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'description')">
    <meta name="theme-color" content="#1A1A2E">
    <meta name="author" content="Minecraft Inventory Builder">

    <meta property="og:title" content="@yield('title') | Minecraft Inventory Builder">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="">
    <meta property="og:description" content="@yield('description', 'description')">
    <meta property="og:site_name" content="Minecraft Inventory Builder">
    @stack('meta')

<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Minecraft Inventory Builder </title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">

    <!-- Styles // Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('scripts')

    @stack('styles')
</head>

<body>
<div id="app">
    <header class="header position-relative">
        @include('elements.navbar')
    </header>

    @yield('app')

    @include('layouts.footer')
</div>

@stack('footer-scripts')

@if(isset($toast))
    <script>
        window.addEventListener('load', function () {
            window.toast('{{ $toast['type'] }}', '{{ $toast['title'] }}', '{{ $toast['description'] }}', {{ $toast['duration'] }})
        })
    </script>
@endif
@if(Session::has('toast'))
    <script>
        window.addEventListener('load', function () {
            window.toast('{{ Session::get('toast')['type'] }}', '{{ Session::get('toast')['title'] }}', '{{ Session::get('toast')['description'] }}', {{ Session::get('toast')['duration'] }})
        })
    </script>
@endif

</body>
</html>
