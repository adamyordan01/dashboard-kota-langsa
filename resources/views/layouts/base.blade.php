<!doctype html>
<html lang="en" data-bs-theme="semi-dark">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $title ?? 'Dashboard' }} | {{ config('app.name') }}</title>
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png">

	<!--plugins-->
	<link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/metismenu/metisMenu.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/metismenu/metisMenu.min.css') }}">
    
	<!--bootstrap css-->
	{{-- <link href="assets/css/bootstrap.min.css" rel="stylesheet"> --}}
	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
	<!--main css-->
	<link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="{{ asset('sass/main.css') }}" rel="stylesheet">
	<link href="{{ asset('sass/dark-theme.css') }}" rel="stylesheet">
	<link href="{{ asset('sass/semi-dark.css') }}" rel="stylesheet">
	<link href="{{ asset('sass/bordered-theme.css') }}" rel="stylesheet">
	<link href="{{ asset('sass/responsive.css') }}" rel="stylesheet">

    @stack('style')
</head>

<body>

	<!--start header-->
	@include('layouts.modules.header')
	<!--end top header-->

	<!--start mini sidebar-->
	@include('layouts.modules.mini-sidebar')
	<!--end mini sidebar-->


	<!--start main wrapper-->
	<main class="main-wrapper mb-5">
		<div class="main-content">
			<!--breadcrumb-->
			<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
				<div class="breadcrumb-title pe-3">Components</div>
				<div class="ps-3">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-0 p-0">
							<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">Starter Page</li>
						</ol>
					</nav>
				</div>
			</div>
			<!--end breadcrumb-->
			{{-- <h3 class="mb-0">Main Content</h3> --}}
            @yield('content')
		</div>
	</main>
	<!--end main wrapper-->

	<!--start footer-->
	<footer class="page-footer">
		<h3 class="mb-0">Page footer</h3>
	</footer>
	<!--top footer-->

	<!--start cart-->
	<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart">
		<div class="offcanvas-header border-bottom h-70">
			<h5 class="mb-0" id="offcanvasRightLabel">8 New Orders</h5>
			<a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
				<i class="material-icons-outlined">close</i>
			</a>
		</div>
		<div class="offcanvas-body p-0">
			<div class="order-list">
				<div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
					<div class="order-img">
						<img src="https://placehold.co/75x50" class="img-fluid rounded-3" width="75" alt="">
					</div>
					<div class="order-info flex-grow-1">
						<h5 class="mb-1 order-title">White Men Shoes</h5>
						<p class="mb-0 order-price">$289</p>
					</div>
					<div class="d-flex">
						<a class="order-delete"><span class="material-icons-outlined">delete</span></a>
						<a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
					</div>
				</div>

				<div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
					<div class="order-img">
						<img src="https://placehold.co/75x50" class="img-fluid rounded-3" width="75" alt="">
					</div>
					<div class="order-info flex-grow-1">
						<h5 class="mb-1 order-title">Red Airpods</h5>
						<p class="mb-0 order-price">$149</p>
					</div>
					<div class="d-flex">
						<a class="order-delete"><span class="material-icons-outlined">delete</span></a>
						<a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
					</div>
				</div>

				<div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
					<div class="order-img">
						<img src="https://placehold.co/75x50" class="img-fluid rounded-3" width="75" alt="">
					</div>
					<div class="order-info flex-grow-1">
						<h5 class="mb-1 order-title">Men Polo Tshirt</h5>
						<p class="mb-0 order-price">$139</p>
					</div>
					<div class="d-flex">
						<a class="order-delete"><span class="material-icons-outlined">delete</span></a>
						<a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
					</div>
				</div>

				<div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
					<div class="order-img">
						<img src="https://placehold.co/75x50" class="img-fluid rounded-3" width="75" alt="">
					</div>
					<div class="order-info flex-grow-1">
						<h5 class="mb-1 order-title">Blue Jeans Casual</h5>
						<p class="mb-0 order-price">$485</p>
					</div>
					<div class="d-flex">
						<a class="order-delete"><span class="material-icons-outlined">delete</span></a>
						<a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
					</div>
				</div>

				<div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
					<div class="order-img">
						<img src="https://placehold.co/75x50" class="img-fluid rounded-3" width="75" alt="">
					</div>
					<div class="order-info flex-grow-1">
						<h5 class="mb-1 order-title">Fancy Shirts</h5>
						<p class="mb-0 order-price">$758</p>
					</div>
					<div class="d-flex">
						<a class="order-delete"><span class="material-icons-outlined">delete</span></a>
						<a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
					</div>
				</div>

				<div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
					<div class="order-img">
						<img src="https://placehold.co/75x50" class="img-fluid rounded-3" width="75" alt="">
					</div>
					<div class="order-info flex-grow-1">
						<h5 class="mb-1 order-title">Home Sofa Set </h5>
						<p class="mb-0 order-price">$546</p>
					</div>
					<div class="d-flex">
						<a class="order-delete"><span class="material-icons-outlined">delete</span></a>
						<a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
					</div>
				</div>

				<div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
					<div class="order-img">
						<img src="https://placehold.co/75x50" class="img-fluid rounded-3" width="75" alt="">
					</div>
					<div class="order-info flex-grow-1">
						<h5 class="mb-1 order-title">Black iPhone</h5>
						<p class="mb-0 order-price">$1049</p>
					</div>
					<div class="d-flex">
						<a class="order-delete"><span class="material-icons-outlined">delete</span></a>
						<a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
					</div>
				</div>

				<div class="order-item d-flex align-items-center gap-3 p-3 border-bottom">
					<div class="order-img">
						<img src="https://placehold.co/75x50" class="img-fluid rounded-3" width="75" alt="">
					</div>
					<div class="order-info flex-grow-1">
						<h5 class="mb-1 order-title">Goldan Watch</h5>
						<p class="mb-0 order-price">$689</p>
					</div>
					<div class="d-flex">
						<a class="order-delete"><span class="material-icons-outlined">delete</span></a>
						<a class="order-delete"><span class="material-icons-outlined">visibility</span></a>
					</div>
				</div>
			</div>
		</div>
		<div class="offcanvas-footer h-70 p-3 border-top">
			<div class="d-grid">
				<button type="button" class="btn btn-dark" data-bs-dismiss="offcanvas">View Products</button>
			</div>
		</div>
	</div>
	<!--end cart-->

	<!--start primary menu offcanvas-->
	@include('layouts.modules.sidebar')
	<!--end primary menu offcanvas-->


	<!--start user details offcanvas-->
	<div class="offcanvas offcanvas-start w-260" data-bs-scroll="true" tabindex="-1" id="offcanvasUserDetails">
		<div class="offcanvas-body">
			<div class="user-wrapper">
				<div class="text-center p-3 bg-light rounded">
					<img src="https://placehold.co/110x110" class="rounded-circle p-1 shadow mb-3" width="120"
						height="120" alt="">
					<h5 class="user-name mb-0 fw-bold">Jhon David</h5>
					<p class="mb-0">Administrator</p>
				</div>
				<div class="list-group list-group-flush mt-3 profil-menu fw-bold">
					<a href="javascript:;"
						class="list-group-item list-group-item-action d-flex align-items-center gap-2 border-top"><i
							class="material-icons-outlined">person_outline</i>Profile</a>
					<a href="javascript:;"
						class="list-group-item list-group-item-action d-flex align-items-center gap-2"><i
							class="material-icons-outlined">local_bar</i>Setting</a>
					<a href="javascript:;"
						class="list-group-item list-group-item-action d-flex align-items-center gap-2"><i
							class="material-icons-outlined">dashboard</i>Dashboard</a>
					<a href="javascript:;"
						class="list-group-item list-group-item-action d-flex align-items-center gap-2"><i
							class="material-icons-outlined">account_balance</i>Earning</a>
					<a href="javascript:;"
						class="list-group-item list-group-item-action d-flex align-items-center gap-2"><i
							class="material-icons-outlined">cloud_download</i>Downloads</a>
					<a href="javascript:;"
						class="list-group-item list-group-item-action d-flex align-items-center gap-2 border-bottom"><i
							class="material-icons-outlined">power_settings_new</i>Logout</a>
				</div>
			</div>

		</div>
		<div class="offcanvas-footer p-3 border-top">
			<div class="text-center">
				<button type="button" class="btn d-flex align-items-center gap-2" data-bs-dismiss="offcanvas"><i
						class="material-icons-outlined">close</i><span>Close Sidebar</span></button>
			</div>
		</div>
	</div>
	<!--end user details offcanvas-->

	<!--start switcher-->
	<button class="btn btn-primary position-fixed bottom-0 end-0 m-3 d-flex align-items-center gap-2" type="button"
		data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop">
		<i class="material-icons-outlined">tune</i>Customize
	</button>

	<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="staticBackdrop">
		<div class="offcanvas-header border-bottom h-70">
			<div class="">
				<h5 class="mb-0">Theme Customizer</h5>
				<p class="mb-0">Customize your theme</p>
			</div>
			<a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
				<i class="material-icons-outlined">close</i>
			</a>
		</div>
		<div class="offcanvas-body">
			<div>
				<p>Theme variation</p>

				<div class="row g-3">
					<div class="col-12 col-xl-6">
						<input type="radio" class="btn-check" name="theme-options" id="LightTheme" checked>
						<label
							class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
							for="LightTheme">
							<span class="material-icons-outlined">light_mode</span>
							<span>Light</span>
						</label>
					</div>
					<div class="col-12 col-xl-6">
						<input type="radio" class="btn-check" name="theme-options" id="DarkTheme">
						<label
							class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
							for="DarkTheme">
							<span class="material-icons-outlined">dark_mode</span>
							<span>Dark</span>
						</label>
					</div>
					<div class="col-12 col-xl-6">
						<input type="radio" class="btn-check" name="theme-options" id="SemiDarkTheme">
						<label
							class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
							for="SemiDarkTheme">
							<span class="material-icons-outlined">contrast</span>
							<span>Semi Dark</span>
						</label>
					</div>
					<div class="col-12 col-xl-6">
						<input type="radio" class="btn-check" name="theme-options" id="BoderedTheme">
						<label
							class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
							for="BoderedTheme">
							<span class="material-icons-outlined">border_style</span>
							<span>Bordered</span>
						</label>
					</div>
				</div>
				<!--end row-->

			</div>
		</div>
	</div>
	<!--start switcher-->

	<!--bootstrap js-->
	<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

	<!--plugins-->
	<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
	<!--plugins-->
	<script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
	<script src="{{ asset('assets/plugins/metismenu/metisMenu.min.js') }}"></script>
	<script src="{{ asset('assets/js/main.js') }}"></script>
    
    @stack('script')

</body>

</html>