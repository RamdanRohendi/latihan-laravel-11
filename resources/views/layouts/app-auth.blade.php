<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My App @hasSection('title') - @yield('title') @endif</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    @stack('styles')
</head>
<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
