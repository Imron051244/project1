@extends('layouts.User.footer')

@section('boostrablogin')
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>

@endsection


@section('content')
<div id="content" class="site-content">
	<!-- Breadcrumb -->
	<div id="breadcrumb">
		<div class="container">
			<h2 class="title">Login</h2>

			<ul class="breadcrumb">
				<li><a href="#" title="Home">Home</a></li>
				<li><span>Login</span></li>
			</ul>
		</div>
	</div>


	<div class="container">
		<div class="login-page">
			<div class="login-form form">
				<div class="block-title">
					<h2 class="title"><span>Login</span></h2>
				</div>

				<form action="{{route('login.action')}}" method="post">
					@csrf
					@if ($errors->any())
						<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
							<strong class="font-bold">ข้อผิดพลาด!</strong>
							<ul>
								@foreach ($errors->all() as $error)
									<li><span class="block sm:inline">{{ $error }}</span></li>
								@endforeach
							</ul>
							<span class="absolute top-0 bottom-0 right-0 px-4 py-3">
								<svg class="fill-current h-6 w-6 text-red-500" role="button"
									xmlns="http://www.w3.org/2000/svg" viewBox="0 0  20 20">
									<title>Close</title>
									<path
										d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
								</svg>
							</span>
						</div>
					@endif
					<div class="form-group">
						<label>Email</label>
						<input type="email" value="{{ old('email') }}" name="email">
					</div>

					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password">
					</div>

					<div class="form-group text-center">
						<div class="link">
							<a href="#">Forgot your password?</a>
							<a href="{{ route('register') }}" style="color:chocolate;">Register ?</a>
						</div>
					</div>

					<div class="form-group text-center">
						<input type="submit" class="btn btn-primary" value="Sign In">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection