<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="follow, index, all">
    <meta content="Shreethemes" name="Minecraft Inventory Builder"/>
    <meta name="theme-color" content="#252539">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="description" content="@yield('description', 'description')">
    <meta name="theme-color" content="#1A1A2E">
    <meta name="author" content="Minecraft Inventory Builder">

    <meta name="keywords"
          content="zmenu, inventory builder, minecraft inventory builder, menu, minecraft menu, inventory configuration, menu configuration, spigot inventory, zmenu spigot">
    <meta property="description"
          content="{{ __("Minecraft Inventory Builder is a site dedicated to the zMenu plugin. The site has a marketplace, an builder editor and a forum.") }}">
    <meta name="description"
          content="{{ __("Minecraft Inventory Builder is a site dedicated to the zMenu plugin. The site has a marketplace, an builder editor and a forum.") }}">

    <base href="{{ route('home') }}">
    <meta property="og:title" content="@yield('title') | Minecraft Inventory Builder">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="">
    <meta property="og:description" content="@yield('description', 'description')">
    <meta property="og:site_name" content="Minecraft Inventory Builder">

    <meta name="msapplication-TileColor" content="#252539">
    <meta name="msapplication-TileImage" content="{{ asset('android-chrome-192x192.png') }}">

    <meta name="author" content="MINECRAFT-INVENTORY-BUILDER.FR [contact@groupez.dev]">
    <meta name="publisher" content="MINECRAFT-INVENTORY-BUILDER.FR [contact@groupez.dev]">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@GroupeZ_">
    <meta name="twitter:creator" content="@GroupeZ_">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title"
          content="{{ __('Minecraft Inventory Builder') }} - @yield('title', __('Liste serveurs Minecraft gratuits et Français'))">
    <meta name="twitter:image" content="{{ asset('android-chrome-192x192.png') }}">
    <meta property="og:title"
          content="{{ __('Minecraft Inventory Builder') }} - @yield('title', __('Liste serveurs Minecraft gratuits et Français'))">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Minecraft Inventory Builder">
    <meta property="og:description"
          content="{{ __("Minecraft Inventory Builder is a site dedicated to the zMenu plugin. The site has a marketplace, an builder editor and a forum.") }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:image" content="{{ asset('android-chrome-192x192.png') }}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    @if(isset($resources) && empty($search))
        <link rel="canonical" href="{{ url()->current() }}">
        @if (!$resources->onFirstPage())
            <link rel="prev" href="{{ $resources->previousPageUrl() }}">
        @endif
        @if ($resources->hasMorePages())
            <link rel="next" href="{{ $resources->nextPageUrl() }}">
        @endif
    @endif

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
