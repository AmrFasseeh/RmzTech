<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    @include('Master.styles')
    @yield('styles')
    <title>RmzTech</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="horizontal-layout horizontal-menu horizontal-menu-padding 1-column blank-page" data-open="click"
    data-menu="horizontal-menu" data-col="1-column">

    @include('Navbar.main')

    <div class="container">
        @if (session('status'))
        <div class="alert alert-success mt-2" role="alert">
            {{ session('status') }}
        </div>
        @endif
        @yield('content')
    </div>

</body>
@include('Master.scripts')
@yield('scripts')
@include('Master.footer')

</html>