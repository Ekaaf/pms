<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="dark" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-bs-theme="galaxy" data-body-image="img-1" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>NFT Dashboard | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{URL::to('assets/images/favicon.ico')}}">

    <!--Swiper slider css-->
    <link href="{{URL::to('assets/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- jsvectormap css -->
    <link href="{{URL::to('assets/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{URL::to('assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{URL::to('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{URL::to('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{URL::to('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{URL::to('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layout.topbar')

        <!-- ========== App Menu ========== -->
        @include('layout.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            @yield('content')
        </div>
        @include('layout.footer')
        </div>
    </div>
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top" style="display: block;">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!-- JAVASCRIPT -->
    <script src="{{URL::to('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{URL::to('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{URL::to('assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{URL::to('assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{URL::to('assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
    <script src="{{URL::to('assets/js/plugins.js')}}"></script>

    <!-- apexcharts -->
    <script src="{{URL::to('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

    <!--Swiper slider js-->
    <script src="{{URL::to('assets/libs/swiper/swiper-bundle.min.js')}}"></script>

    <!-- Vector map-->
    <script src="{{URL::to('assets/libs/jsvectormap/js/jsvectormap.min.js')}}"></script>
    <script src="{{URL::to('assets/libs/jsvectormap/maps/world-merc.js')}}"></script>

    <!-- Countdown js -->
    <script src="{{URL::to('assets/js/pages/coming-soon.init.js')}}"></script>

    <!-- Marketplace init -->
    <script src="{{URL::to('assets/js/pages/dashboard-nft.init.js')}}"></script>

    <!-- App js -->
    <script src="{{URL::to('assets/js/app.js')}}"></script>
</body>

</html>