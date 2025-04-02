<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS for carousel/flickity-->
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity-fade@2/flickity-fade.css">

    <!-- CSS for modal/flowbite -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css"  rel="stylesheet" /> -->
</head>

<body class="font-poppins text-cp-black">

    {{-- Menandai lokasi placeholder di master layout untuk konten halaman spesifik. --}}
    @yield('content')

    {{-- Digunakan untuk memasukkan skrip atau elemen lain sebelum atau setelah lokasi tertentu dalam layout utama. --}}
    @stack('before-scripts')
    {{-- // file jadi di sini.... khusus semua halaman --}}
    @stack('after-scripts')

</body>

</html>

{{-- DOKUMENTASI PENJELASAN
@extends: Menghubungkan halaman dengan master layout.
@section('content'): Menyediakan konten untuk menggantikan @yield('content') di master layout.
@push('...') dan @stack('...'): Menambahkan konten dinamis ke lokasi yang ditentukan di master layout.
@yield: Placeholder di master layout untuk konten halaman.
--}}
