<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My App @hasSection('title') - @yield('title') @endif</title>

   <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
	@include('layouts.partials.admin.sidebar')

	@include('layouts.partials.admin.navbar')

	<main class="p-4 sm:ml-64">
        @yield('isi')

        @include('layouts.partials.admin.footer')
	</main>

	<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>
</html>
