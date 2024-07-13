<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ZKTeco</title>
    {{-- <link href="{{ asset("asset/boot/css/bootstrap.mini.css") }}" rel="stylesheet" type="text/css" /> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('asset/vendors/base/flowbite.min.css') }}" />

     <link rel="stylesheet" href="{{ asset('asset/vendors/sweetalert2/dist/sweetalert2.min.css') }}"> 
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>

    <link href="../../asset/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css"/>

    <!--RTL version:<link href="../../asset/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
    <link href="../../asset/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />


    <!--RTL version:<link href="../../asset/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

    <!--end::Global Theme Styles -->
    <script>
         WebFont.load({
        google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
        active: function() {
            sessionStorage.fonts = true;
        }
      });
    </script>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
		<link href="../../../asset/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
		<link href="../../../asset/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
		<link href="../../../asset/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
</head>
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

    <div class="m-grid m-grid--hor m-grid--root m-page">
     @include('layout.header')
     
     @include('layout.sidebar')
     @yield('content')

    </div> 
    <script type="text/javascript" src="{{ asset('asset/vendors/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/vendors/sweetalert2/dist/sweetalert2.init.js') }}">
   <!-- Bootstrap JS -->
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="{{ asset('asset/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset("asset/vendors/base/vendors.bundle.js") }}" type="text/javascript"></script>
		<script src="{{ asset("asset/demo/default/base/scripts.bundle.js") }}" type="text/javascript"></script>


		<!--end::Global Theme Bundle -->

		<!--begin::Page Vendors -->
		<script src="{{ asset("asset/vendors/custom/datatables/datatables.bundle.js") }}" type="text/javascript"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>

		<script src="{{ asset("asset/demo/default/custom/crud/datatables/basic/scrollable.js") }}" type="text/javascript"></script>
    <script src="{{ asset("asset/demo/default/custom/header/actions.js") }}" type="text/javascript"></script>

    @yield('alert')
    @yield('script_jquey')

</body>
</html>