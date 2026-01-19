<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
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

	<!-- Wrapper full height -->
	<div class="container-xxl">
		<div class="authentication-wrapper authentication-basic container-p-y">
			<div class="authentication-inner">
				@yield("content")
			</div>
		</div>
	</div>

</body>

</html>
