<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>
    <title>Dobry Chlast</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>

<body>
    <div class="wrapper">
        @include('components.header')
        @yield('content')
    </div>
    {{-- @include('components.errors') --}}
    @include('components.footer')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    @stack('scripts')
</body>

</html>
