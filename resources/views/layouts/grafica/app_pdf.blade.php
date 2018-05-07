<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>Stampa</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css" media="screen">
        .page-break {
            page-break-after: always;
        } 
        div#pdf_filter_container {
            border: 1px solid #333;
            padding: 5px;
        }
        div#pdf_filter {
            margin-top: 0px;
            padding-top: 0px;
            float: left;
        }
        div#pdf_logo {
            margin-top: 0px;
            padding-top: 0px;
            float: right;
        }
        div.clear {
            clear: both;
        }
        div.border {
            border: 1px solid #333;
        }
        p.page_number {
            text-align: left;
            margin-left:1px;
            margin-bottom: 20px;
        }
        tr.deleted td {
            background-color: #ccc;
        }
    </style>    
</head>

    <section class="content-pdf">
        @yield('content')
    </section>

</body>
</html>
