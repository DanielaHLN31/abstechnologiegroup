@php
    $prefix = Request::route()->getPrefix();
    $route = Route::current()->getName();
@endphp
<!doctype html>

<html
    lang="fr"
    class="light-style layout-navbar-fixed layout-menu-fixed "
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{ asset('') }}"
    data-template="vertical-menu-template">
<head>

    @include('admin.body.header')

    <style>
        #tasks-toast {
            max-width: 350px;
            width: 100%;
        }

        #tasks-toast .toast-body {
            max-height: 60vh;
            overflow-y: auto;
            background-color: white !important;
        }
    </style>
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

@if(Auth::check())
 
  
@endif

            @include('admin.body.sidebar')

        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            @include('admin.body.navbar')

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

            @yield('content')
                <!-- / Content -->

                <!-- Footer -->
            @include('admin.body.footer')
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js backend/vendor/js/core.js -->

@include('admin.body.script')
</body>
</html>
