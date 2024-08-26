<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My App @hasSection('title') - @yield('title') @endif</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    @stack('styles')
</head>
<body class="h-full">
    <div class="min-h-full">
        @include('layouts.partials.navbar')

        @hasSection('header')
            @include('layouts.partials.header')
        @endif

        <main class="bg-white">
            @yield('content')
        </main>

        @include('layouts.partials.footer')
    </div>

    @stack('scripts')
</body>
</html>
