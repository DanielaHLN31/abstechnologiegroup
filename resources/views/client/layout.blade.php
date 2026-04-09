<!DOCTYPE html>
<html lang="en">
<head>
	@include('client.body.head')		
		
</head>

<body class="animsition">
	<!-- Header -->
	@include('client.body.header')

	@include('frontend.partials.modal')


    @yield('content')

	@include('client.body.footer')
	@include('frontend.partials.productModal')

	@include('frontend.script.js_links')


</body>
</html>