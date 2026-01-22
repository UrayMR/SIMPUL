<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
	data-assets-path="{{ asset('assets/') }}/" data-template="vertical-menu-template-free">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title>{{ config('app.name') }} - @yield('title')</title>

	<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">
	<link rel="apple-touch-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">

	<!-- Vite CSS -->
	@vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body>
	<div class="d-flex justify-content-center align-items-center bg-light" style="min-height:100vh;">
		@yield('content')
	</div>
</body>

</html>
