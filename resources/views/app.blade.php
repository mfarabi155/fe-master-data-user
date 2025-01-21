<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <!-- Menyertakan Bootstrap dan FontAwesome -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Menambahkan pengecekan token di frontend -->
    <script>
        // Cek apakah token ada di localStorage
        const token = localStorage.getItem('token');

        // Jika token tidak ada, redirect ke halaman login
        if (!token) {
            window.location.href = '/login';
        }
    </script>
</head>
<body>
    <div class="d-flex" id="app">
        <!-- Sidebar, termasuk menu navigasi -->
        @include('sidebar')  <!-- Pastikan Anda memiliki file sidebar.blade.php -->

        <!-- Konten utama -->
        <div class="container-fluid" style="margin-left: 250px; padding-top: 20px;">
            @yield('content')  <!-- Halaman konten yang menggunakan layout ini -->
        </div>
    </div>

    <!-- Menambahkan JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
