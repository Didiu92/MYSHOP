<meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>@yield('title', 'Mi Tienda Online')</title>
 <script src="https://cdn.tailwindcss.com"></script>
 <script>
 tailwind.config = {
 theme: {
 extend: {
 colors: {
 primary: {
 500: '#3b82f6',
 600: '#2563eb',
 700: '#1d4ed8',
 }
 }
 }
 }
 }
 </script>
 @stack('styles')
