<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCT</title>
    @include('back.layouts.styles')
    @stack('custom-styles')
</head>

<body>

            @yield('content')
            <!-- @include('back.layouts.footer') -->
        
        @include('back.layouts.scripts')
        @stack('custom-scripts')

    
</body>

</html>
