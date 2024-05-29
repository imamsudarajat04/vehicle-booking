<meta charset="utf-8" />
<title>@yield('pageTitle', 'Dashboard')</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- App favicon -->
<link rel="shortcut icon" href="{!! asset('assets/images/favicon.ico') !!}">

<!-- jsvectormap css -->
<link href="{!! asset('assets/libs/jsvectormap/css/jsvectormap.min.css') !!}" rel="stylesheet" type="text/css" />

<!--Swiper slider css-->
<link href="{!! asset('assets/libs/swiper/swiper-bundle.min.css') !!}" rel="stylesheet" type="text/css" />

<!-- Layout config Js -->
<script src="{!! asset('assets/js/layout.js') !!}"></script>
<!-- Bootstrap Css -->
<link href="{!! asset('assets/css/bootstrap.min.css') !!}" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{!! asset('assets/css/icons.min.css') !!}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{!! asset('assets/css/app.min.css') !!}" rel="stylesheet" type="text/css" />
<!-- JQuery & DataTables -->
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/datatables.min.css') }}" />
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<!-- SweetAlert2 -->
@stack('styles')