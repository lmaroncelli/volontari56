<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>Stampa</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css" media="screen">
        .page-break {
            page-break-after: always;
        } 
    </style>    
</head>

    <section class="content-pdf">
        @yield('content')
    </section>

</body>
</html>
