<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/skins/skin-blue.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    
    @yield('header_css')

    <link href="{{ asset('css/AdminLTE.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">
        
        @include('layouts.header')

        @include('layouts.sidebar')
        
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('briciole','')

            <!-- Main content -->    
            <section class="content container-fluid">
                @include('layouts.errors')
                @yield('content')
            </section>
        </div>   <!-- /.content-wrapper -->
        @include('layouts.footer')
        @include('layouts.aside')
        <div class="control-sidebar-bg"></div>
    </div> <!-- ./wrapper -->
    
    <!-- Scripts -->
    
    <!-- jQuery 3 -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('js/bootstrap.js') }}"></script>
   <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}"></script>

    @yield('script_footer')

</body>
</html>
