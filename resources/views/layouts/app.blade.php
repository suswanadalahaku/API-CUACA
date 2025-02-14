<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Weather App')</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

</head>
{{-- <body class="relative min-h-screen flex">

    <!-- Sidebar -->
    <div class="w-1/5 bg-gray-800 text-white h-screen p-4 fixed left-0 top-0 pt-20">
        <ul>
            <li><a href="#" class="block p-4 hover:bg-gray-700">Dashboard</a></li>
            <li><a href="#" class="block p-4 hover:bg-gray-700">Settings</a></li>
            <!-- Tambahkan menu lain jika diperlukan -->
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 ml-[20%] pl-4 bg-white">
        @include('components.navbar') <!-- Navbar tetap -->
        <div class="bg-white p-6 shadow-lg w-full flex-1 mt-20">
            @yield('content') <!-- Bagian konten utama yang akan berubah -->
        </div>
    </div>
</body> --}}
<body class="relative bg-cover bg-center min-h-screen flex">
    <!-- Sidebar -->
    @include('components.side-menu')

    <div class="flex-1 flex flex-col bg-gradient-to-br from-blue-200 to-gray-200">
        @include('components.navbar') <!-- Include Navbar -->

        <!-- Main Content -->
        <div class="p-6 shadow-lg w-full flex-1 mt-20"> <!-- Add mt-20 to provide space for navbar -->
            @yield('content')
        </div>
    </div>
{{-- 
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (!document.querySelector('[data-weather-loaded="true"]')) {
                console.log('Weather not loaded, getting location...');
                if (navigator.geolocation) {
                    // Mengambil lokasi hanya sekali, bukan terus-menerus
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        
                        // Panggil fungsi untuk mendapatkan data cuaca menggunakan latitude dan longitude
                        getWeatherData(latitude, longitude);
                    }, function(error) {
                        // Tampilkan pesan error jika terjadi masalah dengan geolocation
                        alert("Error obtaining location: " + error.message);
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            } else {
                console.log('Weather already loaded');
            }
        });
    </script> --}}

</body>
</html>
