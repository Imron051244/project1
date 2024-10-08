<!DOCTYPE html>
<html lang="zxx">

<head>
	<!-- Basic Page Needs -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>S-H-P-M - Organic, Fresh Food,</title>

	<meta name="keywords" content="Organic, Fresh Food, Farm Store">
	<meta name="description" content="FreshMart - Organic, Fresh Food, Farm Store HTML Template">
	<meta name="author" content="tivatheme">
	@yield('boostrablogin')
	
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<!-- Favicon -->
	<link rel="shortcut icon" href="{{asset('img/favicon.png')}}" type="image/png">

	<!-- Mobile Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display:300,400,700" rel="stylesheet">

	<!-- Vendor CSS -->
	<link rel="stylesheet" href="{{asset('libs/bootstrap/css/bootstrap.css')}}">
	<link rel="stylesheet" href="{{asset('libs/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('libs/font-material/css/material-design-iconic-font.min.css')}}">
	<link rel="stylesheet" href="{{asset('libs/nivo-slider/css/nivo-slider.css')}}">
	<link rel="stylesheet" href="{{asset('libs/nivo-slider/css/animate.css')}}">
	<link rel="stylesheet" href="{{asset('libs/nivo-slider/css/style.css')}}">
	<link rel="stylesheet" href="{{asset('libs/owl.carousel/assets/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('libs/slider-range/css/jslider.css')}}">

	<!-- Template CSS -->
	<link rel="stylesheet" href="{{asset('css/style.css')}}">
	<link rel="stylesheet" href="{{asset('css/reponsive.css')}}">
</head>

<body class="home home-1">
	<div id="all">
		<!-- Header -->
		@yield('Header')


		<!-- Main Content -->
		@yield('content')



		<!-- Footer -->
		@yield('Footer')



		<!-- Go Up button -->
		<div class="go-up">
			<a href="#">
				<i class="fa fa-long-arrow-up"></i>
			</a>
		</div>

		<!-- Page Loader -->
		<div id="page-preloader">
			<div class="page-loading">
				<div class="dot"></div>
				<div class="dot"></div>
				<div class="dot"></div>
				<div class="dot"></div>
				<div class="dot"></div>
			</div>
		</div>
	</div>

	@yield('Ajax')


	<!-- Vendor JS -->
	<script src="{{asset('libs/jquery/jquery.js')}}"></script>
	<script src="{{asset('libs/bootstrap/js/bootstrap.js')}}"></script>
	<script src="{{asset('libs/jquery.countdown/jquery.countdown.js')}}"></script>
	<script src="{{asset('libs/nivo-slider/js/jquery.nivo.slider.js')}}"></script>
	<script src="{{asset('libs/owl.carousel/owl.carousel.min.js')}}"></script>
	<script src="{{asset('libs/slider-range/js/tmpl.js')}}"></script>
	<script src="{{asset('libs/slider-range/js/jquery.dependClass-0.1.js')}}"></script>
	<script src="{{asset('libs/slider-range/js/draggable-0.1.js')}}"></script>
	<script src="{{asset('libs/slider-range/js/jquery.slider.js')}}"></script>
	<script src="{{asset('libs/elevatezoom/jquery.elevatezoom.js')}}"></script>

	<!-- Template CSS -->
	<script src="{{asset('js/main.js')}}"></script>
</body>



</html>