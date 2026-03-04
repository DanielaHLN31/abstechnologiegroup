<meta charset="utf-8" />
<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    @yield('title') 

<meta name="description" content="@yield('description')">
<meta name="author" content="ABSTECHNOLOGIE">

<meta name="csrf-token" content="{{ csrf_token() }}">


<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="{{ asset('backend/img/favicon/favicon.png')}}" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
    rel="stylesheet" />

<!-- Icons -->
<link rel="stylesheet" href="{{ asset('backend/vendor/fonts/fontawesome.css')}}" />
<link rel="stylesheet" href="{{ asset('backend/vendor/fonts/tabler-icons.css')}}" />
<link rel="stylesheet" href="{{ asset('backend/vendor/fonts/flag-icons.css')}}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('backend/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset('backend/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ asset('backend/css/demo.css')}}" />

<link rel="stylesheet" href="{{ asset('backend/vendor/css/core.css')}}" class="template-customizer-core-css" />
<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('backend/vendor/libs/node-waves/node-waves.css')}}" />
<link rel="stylesheet" href="{{ asset('backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
<link rel="stylesheet" href="{{ asset('backend/vendor/libs/typeahead-js/typeahead.css')}}" />
<link rel="stylesheet" href="{{ asset('backend/vendor/libs/apex-charts/apex-charts.css')}}" />
<link rel="stylesheet" href="{{ asset('backend/vendor/libs/swiper/swiper.css')}}" />
<link rel="stylesheet" href="{{ asset('backend/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{ asset('backend/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{ asset('backend/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}" />
<link rel="stylesheet" href="{{ asset('backend/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{ asset('backend/vendor/libs/flatpickr/flatpickr.css')}}" />

<link rel="stylesheet" href="{{ asset('backend/vendor/libs/animate-css/animate.css')}}" />
<link rel="stylesheet" href="{{ asset('backend/css/iziToast.min.css')}}" />

<!-- Page CSS -->
<link rel="stylesheet" href="{{ asset('backend/vendor/css/pages/cards-advance.css')}}" />

<!-- Helpers -->
<script src="{{ asset('backend/vendor/js/helpers.js')}}"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
<script src="{{ asset('backend/vendor/js/template-customizer.js')}}"></script>
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

<script src="{{ asset('backend/js/config.js')}}"></script>

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('backend/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset('backend/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />


<style>

    .btn-primary, .btn-primary:active, .btn-primary:focus{
        border-color: var(--color-primary) !important;
        background-color: var(--color-primary) !important;
    }
    .btn-secondary , .btn-secondary:active , .btn-secondary:focus{
        border-color: var(--color-secondary) !important;
        background-color: var(--color-secondary) !important;
    }

    .border-primary{
        border-color: var(--color-primary) !important;
    }
    .border-secondary{
        border-color: var(--color-secondary) !important;
    }

    .text-primary{
        color: var(--color-primary) !important;
    }
    .text-secondary{
        color: var(--color-secondary) !important;
    }

    .bg-primary{
        background: var(--color-primary) !important;
    }

    .bg-secondary{
        background: var(--color-secondary) !important;
    }

    .breadcrumb-item, .breadcrumb-item a{
        color: var(--color-primary);
    }

    .main-menu.menu-light .navigation>li.active>a {
        background: -webkit-linear-gradient(332deg, var(--color-primary) , var(--color-secondary));
        background: linear-gradient(118deg, var(--color-primary), var(--color-secondary));
        box-shadow: 0 0 10px 1px transparent;
    }

    .main-menu.menu-light .navigation>li ul .active,
    .bg-menu-theme.menu-vertical .menu-item.active > .menu-link:not(.menu-toggle)
    {
        background: -webkit-linear-gradient(332deg, var(--color-primary) , var(--color-primary));
        background: linear-gradient(118deg, var(--color-primary), var(--color-primary));
        box-shadow: 0 0 10px 1px transparent;
    }

    a, a:hover, a:active, a:focus{
        color: var(--color-primary);
    }

    .page-item.active .page-link {
        background-color: var(--color-primary) !important;
    }

    :root {
        --color-primary: #0066CC;
        --color-secondary: #ff9c05;
    }
</style>

@stack('links')
