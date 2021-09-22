<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <title>{{ $title }}</title>
    @stack('css')
</head>

<body class="bg-white">
    <div class="container-fluid">
        @yield('content-pdf')
    </div>
    @stack('js')
</body>

</html>
