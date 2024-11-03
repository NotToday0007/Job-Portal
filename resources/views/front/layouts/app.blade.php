{{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}
<!-- Bootstrap CSS -->

<!-- Bootstrap Bundle JS (with Popper.js) -->
{{-- <link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet" />
<script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script> --}}
<!DOCTYPE html>
<html class="no-js" lang="en_AU">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>CareerVibe | Find Best Jobs</title>
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
	<meta name="HandheldFriendly" content="True" />
	<meta name="pinterest" content="nopin" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css" integrity="sha512-Fm8kRNVGCBZn0sPmwJbVXlqfJmPC13zRsMElZenX6v721g/H7OukJd8XzDEBRQ2FSATK8xNF9UYvzsCtUpfeJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}" />


	<!-- Fav Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="#" />
</head>
<body data-instant-intensity="mousedown">
<header>
	<nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3">
		<div class="container">
			<a class="navbar-brand" href="{{url('/')}}">CareerVibe</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="{{url('/')}}">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="{{url('/find-jobs')}}">Find Jobs</a>
					</li>
				</ul>
				<a class="btn btn-outline-primary me-2" href="{{ route('logIN') }}" type="submit">Login</a>
				<a class="btn btn-primary" href="{{ url('/post-job') }}" type="submit">Post a Job</a>
			</div>
		</div>
	</nav>
</header>



@yield('main')
@yield('login')
@yield('register')
@yield('account')
@yield('postjob')
@yield('findjobs')
@yield('jobdetails')
<footer class="bg-dark py-3 bg-2">
    <div class="container">
        <p class="text-center text-white pt-3 fw-bold fs-6">© 2023 xyz company, all right reserved</p>
    </div>
    </footer>
    <div id="loader" class="loader"></div>
    {{-- document.addEventListener('DOMContentLoaded', () => {
        hideLoader(); // Hide loader when job view page is fully loaded
    }); --}}
<!-- jQuery - Load first as other libraries depend on it -->
<script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>

<!-- Bootstrap Bundle (includes Popper) - Load after jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Additional Libraries -->
<script src="{{ asset('assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('assets/js/lazyload.17.6.0.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js" integrity="sha512-YJgZG+6o3xSc0k5wv774GS+W1gx0vuSI/kr0E0UylL/Qg/noNspPtYwHPN9q6n59CTR/uhgXfjDXLTRI+uIryg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('assets/js/common.js') }}"></script> <!-- Ensure this is included -->

<!-- Axios - Load only once -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<!-- DataTables CSS -->
<link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" />

<!-- DataTables JS - Load after jQuery -->
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>

<!-- Custom JavaScript (Load last to ensure other libraries are ready) -->
<script src="{{ asset('assets/js/custom.js') }}"></script>

<script src="{{ asset('assets/js/messageHandler.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/messageStyles.css') }}">

<script src="{{ asset('assets/js/common.js') }}"></script> <!-- Ensure this is included -->

<link rel="stylesheet" href="{{ asset('assets/css/loader.css') }}">



