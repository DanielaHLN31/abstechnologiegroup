
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
    <!-- META DESCRIPTION (150-160 caractères) -->
    {{-- <meta name="description" content="ABS Technologie Group, distributeur agréé Samsung|Smartphones|Informatique|Électroménager au Bénin.|CAMP-GUEZO, Face Hôpital des Armées (HIA)|Lundi - Samedi : 9h00 - 18h00, Dimanche : Fermé | +229 01 61 06 26 26 - +229 01 96 06 26 26| Venez découvrir nos équipements en exclusivité dans notre showroom moderne et entièrement équipé. Vente d'appareils électroménagers, smartphones, TV QLED à Cotonou. SAV professionnel."> --}}
    
    {{-- Meta description — max 160 caractères --}}
    <meta name="description" content="@yield('meta_description', 'ABS Technologie Group, distributeur agréé Samsung au Bénin. Électroménager, smartphones, informatique et SAV professionnel à Cotonou.')">

    {{-- Keywords — utiles mais pas prioritaires pour Google --}}
    <meta name="keywords" content="@yield('meta_keywords', 'ABS Technologie, Samsung Bénin, électroménager Cotonou, smartphones Bénin, distributeur Samsung, SAV électroménager')">

    {{-- Robots --}}
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">

    {{-- Langue --}}
    <meta name="language" content="French">
    <meta http-equiv="content-language" content="fr-BJ">

    {{-- Auteur --}}
    <meta name="author" content="ABS Technologie Group">

    {{-- Canonical — évite le duplicate content --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- == GEO LOCAL == --}}
    <meta name="geo.region" content="BJ-LI">
    <meta name="geo.placename" content="Cotonou, Bénin">
    <meta name="geo.position" content="6.356074;2.4155022">
    <meta name="ICBM" content="6.356074, 2.4155022">

    {{-- == OPEN GRAPH == --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="ABS Technologie Group">
    <meta property="og:locale" content="fr_BJ">
    <meta property="og:title" content="@yield('og_title', 'ABS Technologie Group | Distributeur Samsung au Bénin')">
    <meta property="og:description" content="@yield('og_description', 'Distributeur agréé Samsung au Bénin. Électroménager, smartphones, informatique et SAV professionnel à Cotonou.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-cover.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="@yield('og_image_alt', 'ABS Technologie Group - High-Tech au Bénin')">

    {{-- == TWITTER CARD == --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('og_title', 'ABS Technologie Group | Distributeur Samsung au Bénin')">
    <meta name="twitter:description" content="@yield('og_description', 'Distributeur agréé Samsung au Bénin. Électroménager, smartphones et SAV professionnel.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-cover.jpg'))">
    <meta name="twitter:image:alt" content="@yield('og_image_alt', 'ABS Technologie Group - High-Tech au Bénin')">


    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('backend/img/favicon/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('backend/img/favicon/favicon.png') }}">

    
	<!--===============================================================================================-->	
		<link rel="icon" type="image/png" href="{{ asset('frontend/images/icons/favicon.png') }}"/>
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" media="print" onload="this.media='all'">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}" media="print" onload="this.media='all'">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/fonts/iconic/css/material-design-iconic-font.min.css') }}" media="print" onload="this.media='all'">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/fonts/linearicons-v1.0.0/icon-font.min.css') }}" media="print" onload="this.media='all'">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/animate/animate.css') }}">
	<!--===============================================================================================-->	
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/css-hamburgers/hamburgers.min.css') }}" media="print" onload="this.media='all'">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/animsition/css/animsition.min.css') }}" media="print" onload="this.media='all'">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/select2/select2.min.css') }}" media="print" onload="this.media='all'">
	<!--===============================================================================================-->	
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/daterangepicker/daterangepicker.css') }}" media="print" onload="this.media='all'">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/slick/slick.css') }}" media="print" onload="this.media='all'">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/MagnificPopup/magnific-popup.css') }}" media="print" onload="this.media='all'">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" media="print" onload="this.media='all'">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/util.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/main.css') }}">
		<link rel="preload" as="image" href="{{ asset('frontend/images/bg-3.png') }}" fetchpriority="high">
	<!--===============================================================================================-->

