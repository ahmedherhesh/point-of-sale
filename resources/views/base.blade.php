<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    @vite('resources/css/app.css')
</head>

<body>
    @yield('content')
    @if (session()->has('fail'))
    @endif

    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @if (session()->has('success'))
        <p class="text-center">{{ session()->get('success') }}</p>
    @endif

    @if (session()->has('failed'))
        <p class="text-center">{{ session()->get('failed') }}</p>
    @endif


    <script>
        $('.alert-success').fadeOut(6000)
        $('.alert-danger').fadeOut(6000)
    </script>

    @yield('js')
</body>

</html>
