<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>PTPN IV Regional III | ID Card Generator</title>
        {{-- stylesheet --}}
        @stack('css')
    </head>
    <body id="page-top">
        @include('layouts.navbar')
        <div class="content">
            @yield('content')
        </div>
        @include('layouts.footer')
        {{-- javascript --}}
        @stack('js')
    </body>
</html>
