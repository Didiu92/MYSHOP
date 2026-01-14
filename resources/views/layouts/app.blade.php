<!DOCTYPE html>
<html lang="es">
<head>
 @include('partials.head')
</head>
<body class="bg-gray-50">
 <!-- Header usando partial -->
 @include('partials.header')
 <!-- Contenido principal -->
 <main class="min-h-screen">
 @yield('content')
 </main>
 <!-- Footer usando partial -->
 @include('partials.footer')
 @stack('scripts')
</body>
</html>