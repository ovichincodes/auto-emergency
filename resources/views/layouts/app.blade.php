<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ $title }} - {{ config('app.name') }}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.min.css') }}">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{ asset('css/jquery-jvectormap.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset('css/_all-skins.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/blue.css') }}">

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>

    <body class="hold-transition {{ $class ?? 'skin-blue sidebar-mini' }}">
        @yield('content')

        <!-- jQuery 3 -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        {{-- select js --}}
        <script src="{{ asset('js/select2.full.min.js') }}"></script>
        <!-- FastClick -->
        <script src="{{ asset('js/fastclick.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('js/adminlte.min.js') }}"></script>
        <!-- Sparkline -->
        <script src="{{ asset('js/jquery.sparkline.min.js') }}"></script>
        <!-- jvectormap  -->
        <script src="{{ asset('js/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ asset('js/jquery-jvectormap-world-mill-en.js') }}"></script>
        <!-- SlimScroll -->
        <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
        <!-- ChartJS -->
        <script src="{{ asset('js/Chart.js') }}"></script>
        {{-- icheck css for login --}}
        <script src="{{ asset('js/icheck.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-notify.js') }}"></script>
        <script defer src="https://maps.googleapis.com/maps/api/js?callback=loadServiceMap&libraries=places&language=en&key=YOUR_API_KEY_HERE" type="text/javascript"></script>
        <script src="{{ asset('js/axios.min.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
    </body>
</html>
