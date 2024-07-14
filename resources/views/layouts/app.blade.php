<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel App</title>
    <!-- Add your CSS here -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="wrapper">
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
        <div class="main-content">
            @yield('content')
        </div>
    </div>
</body>
</html>
