<!DOCTYPE html>
<html lang="en">

<!-- index-0.html  Tue, 07 Jan 2020 03:35:33 GMT -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Admin &mdash; S-H-P-M</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('assets/modules/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/modules/fontawesome/css/all.min.css')}}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{asset('assets/modules/jqvmap/dist/jqvmap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/modules/weather-icon/css/weather-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/modules/weather-icon/css/weather-icons-wind.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/modules/summernote/summernote-bs4.css')}}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/style.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/components.min.css')}}">
    @yield('style')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Serif+Thai:wght@100..900&display=swap');

        body {
            font-family: 'Noto Serif Thai', serif;
        }
    </style>

</head>

<body class="layout-4">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <span class="loader"><span class="loader-inner"></span></span>
    </div>

    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            <!-- Start app top navbar -->
            <!-- Start main left sidebar menu -->
            @yield('Admin')
            @yield('content')


            <!-- Start app main Content -->

        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{asset('assets/bundles/lib.vendor.bundle.js')}}"></script>
    <script src="{{asset('js/CodiePie.js')}}"></script>

    <!-- JS Libraies -->
    <script src="{{asset('assets/modules/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/modules/simple-weather/jquery.simpleWeather.min.js')}}"></script>
    <script src="{{asset('assets/modules/jqvmap/dist/jquery.vmap.min.js')}}"></script>
    <script src="{{asset('assets/modules/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
    <script src="{{asset('assets/modules/summernote/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>

    <!-- Page Specific JS File -->


    <!-- Template JS File -->
    <script src="{{asset('js/scripts.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>

    @yield('script')

</body>

<!-- index-0.html  Tue, 07 Jan 2020 03:35:42 GMT -->

</html>