<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <title>{{ $title }}</title>
</head>

<body class="bg-white">
    <div class="container-fluid">
        @yield('content-pdf')
    </div>
</body>

</html>
