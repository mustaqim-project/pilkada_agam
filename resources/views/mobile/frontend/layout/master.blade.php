<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">
    <title>Sikadsis</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('mobile/styles/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile/fonts/css/fontawesome-all.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
    <link rel="manifest" href="{{ asset('mobile/_manifest.json') }}" data-pwa-version="set_in_manifest_and_pwa_js">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('mobile/images/logobulat.png') }}">
    <link rel="icon" href="{{ asset('mobile/images/logobulat.png') }}" type="image/png">

    <!-- Leaflet Styles -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>

    <!-- Flatpickr Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body class="theme-light" data-highlight="green3">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">
        @include('mobile.components.header')
        @include('mobile.components.footer-bar')

        <!-- SweetAlert Success -->
        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success'
                , title: 'Success'
                , text: '{{ session('
                success ') }}'
                , timer: 2000
                , showConfirmButton: false
            });

        </script>
        @endif
        @yield('content')



        <div id="menu-share" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="420" data-menu-effect="menu-over">
            @include('mobile.frontend.dashboard.menu-share')
        </div>

        <div id="menu-highlights" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-height="510" data-menu-effect="menu-over">
            @include('mobile.frontend.dashboard.menu-colors')
        </div>

        <div id="menu-main" class="menu menu-box-right menu-box-detached rounded-m" data-menu-width="260" data-menu-active="nav-welcome" data-menu-effect="menu-over">
            @include('mobile.frontend.dashboard.menu-main')
        </div>

        <!-- Be sure this is on your main visiting page, for example, the index page -->
        <!-- Install Prompt for Android -->

    </div>

    <script type="text/javascript" src="{{ asset('mobile/scripts/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/scripts/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mobile/scripts/custom.js') }}"></script>
</body>
</html>
