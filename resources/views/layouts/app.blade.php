<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
    <div id="app">
        @include('layouts.header')
        <div class="wrapper">
            @guest
            @else
                <nav class="sidebar">
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('keuangan') }}">Keuangan</a></li>
                        <li><a href="{{ route('penjualan') }}">Penjualan</a></li>
                        <li><a href="{{ route('stok') }}">Stok</a></li>
                        <li><a href="{{ route('barang') }}">Barang</a></li>
                        <li><a href="{{ route('kategori') }}">Kategori</a></li>
                    </ul>
                </nav>
                @endguest
            <div class="main-content">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>
</html>
