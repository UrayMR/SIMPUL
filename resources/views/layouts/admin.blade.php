<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
	data-assets-path="{{ asset('assets/') }}/" data-template="vertical-menu-template-free">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title>@yield('title') - {{ config('app.name') }}</title>

	<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
	<link rel="apple-touch-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">

	@vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body data-auth-id="{{ auth()->id() }}">
	<div class="layout-wrapper layout-content-navbar">
		<div class="layout-container">

			{{-- Sidebar --}}
			@include('components.admin.sidebar')

			<div class="layout-page">

				{{-- Navbar --}}
				@include('components.admin.navbar')

				<div class="content-wrapper">
					<main class=" container-p-y">
						@yield('content')
					</main>

					{{-- Footer --}}
					@include('components.admin.footer')
				</div>

			</div>
		</div>

	</div>
	<x-toast />

	@stack('scripts')
</body>

</html>
