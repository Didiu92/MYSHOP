<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Aristocats')</title>

<!-- Favicon -->
<link rel="icon" type="image/png" href="{{ asset('images/favicon/favicon.png') }}">
<style>
    link[rel="icon"] {
        border-radius: 50%;
    }
</style>

@stack('styles')
