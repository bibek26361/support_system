<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('back.layouts.styles')
    @stack('custom-styles')
</head>

<body>
    @guest
        @yield('auth-content')
    @else
        @include('back.layouts.header')
        @include('back.layouts.sidebar')
        @yield('content')
        <!-- @include('back.layouts.footer') -->

        @include('back.layouts.scripts')
        @stack('custom-scripts')

    @endguest
</body>

</html>
