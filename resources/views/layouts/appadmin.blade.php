<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
	data-assets-path="{{ asset("assets/") }}/" data-template="vertical-menu-template-free">

<head>
	<meta charset="utf-8" />
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

	<title>{{ config("app.name") }} - @yield("title")</title>

	<!-- Favicon -->
	<link rel="icon" type="image/x-icon" href="{{ asset("assets/img/favicon/favicon.ico") }}" />

	<!-- Google Font -->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
		rel="stylesheet" />

	<!-- Vite CSS -->
	@vite(["resources/scss/app.scss", "resources/js/app.js"])
</head>

<body>
	<div class="layout-wrapper layout-content-navbar">
		<div class="layout-container">

			{{-- Sidebar --}}
			@include("components.admin.sidebar")

			<div class="layout-page">

				{{-- Navbar --}}
				@include("components.admin.navbar")

				<div class="content-wrapper">
					<div class="container-xxl flex-grow-1 container-p-y">
						@yield("content")
					</div>

					{{-- Footer --}}
					@include("components.admin.footer")
				</div>

			</div>
		</div>

	</div>
	<x-toast />

</body>

</html>
