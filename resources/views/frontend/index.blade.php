<!DOCTYPE html>
<html lang="en">
<head>
	<title>Accueil ABS-TECHNOLOGIE</title>
	@include('client.body.head')
		

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{ asset('frontend/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
	
	<style>
		@media (max-width: 768px) {
			.hero-header {
				max-height: none !important;
				padding: 20px 0 30px !important;
			}
			.hero-header .display-4 {
				font-size: 1.6rem;
			}
			.hero-header .position-relative.mx-auto input,
			.hero-header .position-relative.mx-auto button {
				font-size: 14px;
				padding: 10px 14px;
			}
			/* Cache le carousel sur très petit écran */
			.hero-header .col-md-12.col-lg-5 {
				display: none;
			}
		}

		@media (max-width: 576px) {
			.hero-header .position-relative.mx-auto {
				display: flex;
				flex-direction: column;
				gap: 8px;
			}
			.hero-header .position-relative.mx-auto input {
				width: 100% !important;
			}
			.hero-header .position-relative.mx-auto button {
				position: static !important;
				width: 100%;
				border-radius: 4px;
				height: auto !important;
			}
		}

		@media (max-width: 600px) {
			.abs-banner__card {
				min-height: 200px;
				flex-direction: column;
			}
			.abs-banner__img-wrap {
				height: 210px;
				position: relative;
			}
			.abs-banner__content {
				margin-top: 0;
				max-width: 75%;
				padding: 16px;
			}
			.abs-banner__cta {
				opacity: 1;
				transform: none;
				visibility: visible;
				padding: 5px 10px;
			    font-size: 11px;
			}

			.abs-marquee__item {
				padding: 0 10px;
			}


		}

		@media (max-width: 480px) {
			.ps-grid {
				grid-template-columns: repeat(1fr);
				gap: 12px;
				/* padding: 0 4px; */
			}
			/* .ps-card-img { height: 150px; }
			.ps-card-body { padding: 10px 12px 14px; }
			.ps-card-name { font-size: 13px; }
			.ps-price-main { font-size: 14px; }
			.ps-add-btn { padding: 7px 10px; font-size: 11px; } */
			}

			@media (max-width: 320px) {
			.ps-grid {
				grid-template-columns: 1fr;
			}
		}

		@media (max-width: 576px) {
			.ps-filters {
				justify-content: flex-start;
				overflow-x: auto;
				flex-wrap: nowrap;
				padding-bottom: 8px;
				/* Scrollable Montserrattal */
				-webkit-overflow-scrolling: touch;
			}
			.ps-filter-btn {
				flex-shrink: 0;
				font-size: 12px;
				padding: 7px 14px;
			}
		}
	</style>

	<style>
		
			/*** Hero Header ***/
			.hero-header {
				background: linear-gradient(rgba(248, 223, 173, 0.1), rgba(248, 223, 173, 0.1)), url('{{ asset('frontend/images/bg-3.png') }}');
				background-position: center center;
				background-repeat: no-repeat;
				background-size: cover;
				/* height: 500px !important; */
			}

			.carousel-item {
				position: relative;
			}

			.carousel-item a {
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				font-size: 25px;
				background: linear-gradient(rgba(255, 181, 36, 0.7), rgba(255, 181, 36, 0.7));
			}

			.carousel-control-next,
			.carousel-control-prev {
				width: 48px;
				height: 48px;
				border-radius: 48px;
				border: 1px solid var(--bs-white);
				background: var(--bs-primary);
				position: absolute;
				top: 50%;
				transform: translateY(-50%);
			}

			.carousel-control-next {
				margin-right: 20px;
			}

			.carousel-control-prev {
				margin-left: 20px;
			}

			.page-header {
				position: relative;
				background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('{{ asset('frontend/images/bg-3.png') }}');
				background-position: center center;
				background-repeat: no-repeat;
				background-size: cover;
			}

			@media (min-width: 992px) {
				.hero-header,
				.page-header {
					margin-top: 80px !important;
				}
			}

			/* @media (max-width: 920px) {
				.hero-header,
				.page-header {
					margin-top: 97px !important;
				}
			} */
			/*** Hero Header end ***/

	</style>

</head>

<body class="animsition">
	<!-- Header -->
	@include('client.body.header')

	<!-- Cart -->
	{{-- ================================================================
   REMPLACE le bloc "wrap-header-cart" dans ton layout principal
   resources/views/layouts/frontend.blade.php  (ou index.blade.php)
   ================================================================ --}}



	@include('frontend.modal')

	<!-- Hero Start -->
	<div class="container-fluid py-5 hero-header" style="max-height: 500px">
		<div class="container py-5">
			<div class="row g-5 align-items-center">

				{{-- Texte à gauche --}}
				<div class="col-md-12 col-lg-7" style="margin-top: 0px !important">
					<h4 class="mb-3 text-secondary">Technologie & Innovation</h4>
					<h1 class="mb-5 display-4 text-primary">
						Smartphones, Informatique &amp; Électroménager
					</h1>
					@include('frontend.hero-search')
				</div>

				{{-- Carousel à droite - sans cadre --}}
				<div class="col-md-12 col-lg-5" style="margin-top: 0px !important">
					<div id="carouselId" class="carousel slide" data-bs-ride="carousel">
						<div class="carousel-inner" role="listbox">

							<div class="carousel-item active">
								<img src="{{ asset('frontend/images/slide1.png') }}" 
									class="img-fluid w-100" 
									style="object-fit: contain; max-height: 500px;"
									alt="Téléphonie Mobile">
							</div>

							<div class="carousel-item">
								<img src="{{ asset('frontend/images/slide2.png') }}" 
									class="img-fluid special w-100" 
									style="object-fit: contain; max-height: 500px;"
									alt="Informatique" style="margin-top: 0px !important">
							</div>

							<div class="carousel-item">
								<img src="{{ asset('frontend/images/slide3.png') }}" 
									class="img-fluid w-100" 
									style="object-fit: contain; max-height: 500px;"
									alt="Électroménager">
							</div>

							<div class="carousel-item">
								<img src="{{ asset('frontend/images/slide5.png') }}" 
									class="img-fluid w-100" 
									style="object-fit: contain; max-height: 500px;"
									alt="Support Technique">
							</div>

						</div>

						{{-- <button class="carousel-control-prev" type="button" 
								data-bs-target="#carouselId" data-bs-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Précédent</span>
						</button>
						<button class="carousel-control-next" type="button" 
								data-bs-target="#carouselId" data-bs-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Suivant</span>
						</button> --}}
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- Hero End -->

		
	{{-- ══════════════ MARQUEE ══════════════ --}}
	<div class="abs-marquee">
		<div class="abs-marquee__track">
			@foreach($categories->take(6) as $cat)
				<span class="abs-marquee__item">{{ $cat->name }} <span class="abs-marquee__sep">·</span></span>
			@endforeach
			<span class="abs-marquee__item">Support Technique <span class="abs-marquee__sep">·</span></span>
			<span class="abs-marquee__item">Livraison Cotonou <span class="abs-marquee__sep">·</span></span>
			{{-- duplicate for infinite loop --}}
			@foreach($categories->take(6) as $cat)
				<span class="abs-marquee__item">{{ $cat->name }} <span class="abs-marquee__sep">·</span></span>
			@endforeach
			<span class="abs-marquee__item">Support Technique <span class="abs-marquee__sep">·</span></span>
			<span class="abs-marquee__item">Livraison Cotonou <span class="abs-marquee__sep">·</span></span>
		</div>
	</div>


	
	<!-- Banner Section avec cartes uniformes -->
	<section class="abs-banner">
		<!-- Header -->
		<div class="abs-banner__head">
			<div class="abs-banner__pill">
				<span class="abs-banner__pill-dot"></span>
				Nos univers produits
			</div>
			<h2 class="abs-banner__title">Explorez nos <span>catégories</span></h2>
			<p class="abs-banner__sub">Des produits certifiés, livrés rapidement au cœur de Cotonou</p>
		</div>

		<!-- Grille cartes - largeur égale -->
		<div class="abs-banner__grid">
			@foreach($categories->take(3) as $index => $category)
			<a href="{{ route('client.product', ['category' => $category->id]) }}" class="abs-banner__card">
				
				
				<!-- Overlay bleu qui apparaît au hover -->
				<div class="abs-banner__overlay"></div>
				<div class="d-flex">
					<!-- Zone image -->
					<div class="abs-banner__img-wrap">
						@if($category->image)
							<img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" loading="lazy">
						@else
							@php $fallbacks = ['5.png', '6.png', '7.png']; @endphp
							<img src="{{ asset('frontend/images/' . ($fallbacks[$index] ?? '5.png')) }}" alt="{{ $category->name }}" loading="lazy">
						@endif
					</div>
					<!-- Contenu texte -->
					<div class="abs-banner__content">
						<div class="abs-banner__tag">
							<span class="abs-banner__tag-dot"></span>
							@php $tags = ['Smartphones & Accessoires', 'Équipements Domestiques', 'PC & Périphériques']; @endphp
							{{ $tags[$index] ?? 'Nouveautés' }}
						</div>
						<h3 class="abs-banner__name">{{ $category->name }}</h3>
						<p class="abs-banner__desc">
							@php $descs = ['Smartphones, téléphones et accessoires de dernière génération.', 'Appareils électroménagers, climatisation et équipements domestiques.', 'Ordinateurs portables, PC de bureau et périphériques professionnels.']; @endphp
							{{ $descs[$index] ?? ($category->description ?? 'Découvrez notre collection') }}
						</p>
						
						<!-- Bouton Commander qui apparaît au hover -->
						<span class="abs-banner__cta">
							Commander
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
								<path d="M5 12h14M12 5l7 7-7 7"/>
							</svg>
						</span>
					</div>
				</div>
			</a>
			@endforeach
		</div>
	</section>


	<!-- Product -->
	{{-- ============================================================
		SECTION PRODUITS
	============================================================ --}}
	<section class="ps-section">

		{{-- Header --}}
		<div class="ps-header">
			<div class="ps-section-accent"></div>
			<div class="ps-label">
				<span class="ps-label-dot"></span>
				Notre catalogue
			</div>
			<h2 class="ps-title">Nos <span>Produits</span></h2>
			<p class="ps-subtitle">Découvrez une sélection premium de produits tech, high-end &amp; multimédia</p>
		</div>

		{{-- Filtres dynamiques (catégories depuis la BDD) --}}
		<div class="ps-filters">
			<button class="ps-filter-btn active" data-filter="all">
				Tous les produits
			</button>

			@foreach($categories->take(6) as $cat)
			<button class="ps-filter-btn" data-filter="cat-{{ $cat->id }}">
				{{ $cat->name }}
			</button>
			@endforeach
		</div>

		{{-- Grille produits --}}
		<div class="ps-grid" id="psGrid">

			@forelse($products->take(12) as $product)
			<div class="ps-card" data-cat="cat-{{ $product->category_id }}">

				{{-- Zone image --}}
				<div class="ps-card-img">

					{{-- Image produit --}}
					@if($product->images->isNotEmpty())
						<img
							src="{{ asset('storage/' . $product->images->first()->image_path) }}"
							alt="{{ $product->name }}"
							loading="lazy">
					@else
						<img
							src="{{ asset('frontend/images/no-image.jpg') }}"
							alt="{{ $product->name }}"
							loading="lazy">
					@endif

					{{-- Badge (Promo > Nouveau > rien) --}}
					@if($product->compare_price && $product->compare_price > $product->price)
						@php $discount = round((1 - $product->price / $product->compare_price) * 100); @endphp
						<span class="ps-badge badge-promo">-{{ $discount }}%</span>
					@elseif($product->created_at->diffInDays(now()) <= 30)
						<span class="ps-badge badge-new">Nouveau</span>
					@elseif($product->is_featured ?? false)
						<span class="ps-badge badge-top">Top Vente</span>
					@endif

					{{-- Bouton Favori --}}
					<button class="ps-wish js-addwish-b2"
							data-product-id="{{ $product->id }}"
							title="Ajouter aux favoris">
						<svg viewBox="0 0 24 24" width="16" height="16" fill="none"
							stroke="#CC1B1B" stroke-width="2">
							<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67
									l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06
									L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
						</svg>
					</button>

					{{-- Aperçu rapide (ouvre votre modal existant) --}}
					<div class="ps-quickview js-show-modal1"
						data-product-id="{{ $product->id }}"
						data-product-name="{{ $product->name }}"
						data-product-price="{{ $product->price }}"
						data-product-description="{{ $product->description }}"
						data-product-images="{{ json_encode($product->images) }}"
						data-product-colors="{{ json_encode($product->colors) }}"
						data-product-specs="{{ json_encode($product->specifications) }}">
						Aperçu rapide
					</div>

				</div>{{-- /.ps-card-img --}}

				{{-- Corps --}}
				<div class="ps-card-body">

					<span class="ps-card-cat">
						{{ $product->category->name ?? 'Produit' }}
					</span>

					<div class="ps-card-name">{{ $product->name }}</div>

					{{-- Pastilles couleurs --}}
					@if($product->colors->isNotEmpty())
					<div class="ps-card-colors">
						@foreach($product->colors->take(4) as $color)
						<span class="ps-color-dot"
							style="background-color:{{ $color->code }}"
							title="{{ $color->name }}"></span>
						@endforeach
						@if($product->colors->count() > 4)
						<span style="font-size:11px;color:var(--text-muted)">
							+{{ $product->colors->count() - 4 }}
						</span>
						@endif
					</div>
					@endif

					{{-- Footer prix + panier --}}
					<div class="ps-card-footer">

						<div class="ps-price">
							@if($product->compare_price && $product->compare_price > $product->price)
								<span class="ps-price-old">
									{{ number_format($product->compare_price, 0, ',', ' ') }} F
								</span>
							@endif
							<span class="ps-price-main">
								{{ number_format($product->price, 0, ',', ' ') }} F
							</span>
						</div>

						{{-- Bouton Ajouter au panier (reprend votre logique JS existante) --}}
						<button class="ps-add-btn abs-add-to-cart"
								data-product-id="{{ $product->id }}"
								data-product-name="{{ $product->name }}"
								data-product-price="{{ $product->price }}">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
								width="13" height="13" stroke-width="2.5">
								<path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
								<line x1="3" y1="6" x2="21" y2="6"/>
								<path d="M16 10a4 4 0 01-8 0"/>
							</svg>
							Ajouter
						</button>

					</div>{{-- /.ps-card-footer --}}

				</div>{{-- /.ps-card-body --}}

			</div>{{-- /.ps-card --}}
			@empty
			<div style="grid-column:1/-1;text-align:center;padding:60px 0;color:var(--text-muted);">
				Aucun produit disponible pour le moment.
			</div>
			@endforelse

		</div>{{-- /.ps-grid --}}


		{{-- Voir tous les produits --}}
		@if($products->count() > 12)
		<div class="ps-view-all">
			<a href="{{ route('client.product') }}" class="ps-view-all-btn">
				Voir tous les produits
				<svg class="arrow" viewBox="0 0 24 24" width="16" height="16"
					fill="none" stroke="currentColor" stroke-width="2.5">
					<path d="M5 12h14M12 5l7 7-7 7"/>
				</svg>
			</a>
		</div>
		@endif

	</section>

	@include('client.body.footer')
	@include('frontend.productModal')

	<!--===============================================================================================-->
	<!-- 1. CHARGER JQUERY UNE SEULE FOIS (version la plus récente) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
	<!--===============================================================================================-->

	<!-- 2. CHARGER BOOTSTRAP (une seule version) -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

	<!--===============================================================================================-->
	<!-- 3. CHARGER LES AUTRES PLUGINS (dans l'ordre) -->
	<script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/select2/select2.min.js') }}"></script>
	<script>
	$(".js-select2").each(function(){
		$(this).select2({
			minimumResultsForSearch: 20,
			dropdownParent: $(this).next('.dropDownSelect2')
		});
	})
	</script>

	<!-- Daterangepicker -->
	<script src="{{ asset('frontend/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/daterangepicker/daterangepicker.js') }}"></script>

	<!-- Slick Carousel (après jQuery) -->
	<script src="{{ asset('frontend/vendor/slick/slick.min.js') }}"></script>
	<script src="{{ asset('frontend/js/slick-custom.js') }}"></script>

	<!-- Autres plugins -->
	<script src="{{ asset('frontend/vendor/parallax100/parallax100.js') }}"></script>
	<script>
	$('.parallax100').parallax100();
	</script>

	<script src="{{ asset('frontend/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
	<script>
	$('.gallery-lb').each(function() {
		$(this).magnificPopup({
			delegate: 'a',
			type: 'image',
			gallery: {
				enabled:true
			},
			mainClass: 'mfp-fade'
		});
	});
	</script>

	<script src="{{ asset('frontend/vendor/isotope/isotope.pkgd.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/sweetalert/sweetalert.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
	<script>
	$('.js-pscroll').each(function(){
		$(this).css('position','relative');
		$(this).css('overflow','hidden');
		var ps = new PerfectScrollbar(this, {
			wheelSpeed: 1,
			scrollingThreshold: 1000,
			wheelPropagation: false,
		});

		$(window).on('resize', function(){
			ps.update();
		})
	});
	</script>

	<!-- Vos scripts personnalisés -->
	<script src="{{ asset('frontend/js/main.js') }}"></script>

	<!-- Autres librairies -->
	<script src="{{ asset('frontend/lib/easing/easing.min.js') }}" defer></script>
	<script src="{{ asset('frontend/lib/waypoints/waypoints.min.js') }}" defer></script>
	<script src="{{ asset('frontend/lib/lightbox/js/lightbox.min.js') }}" defer></script>
	<script src="{{ asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}" defer></script>

	<!-- ENFIN votre script global (contient le code du modal) -->
	@include('frontend.global_js')

	<script>
		(function () {
		/* Uniquement sur mobile */
		if (window.innerWidth > 991) return;

		var AUTOPLAY_MS = 4500;   /* durée par slide en millisecondes */

		var track    = document.getElementById('amsTrack');
		var dots     = document.querySelectorAll('.ams-dot');
		var progress = document.getElementById('amsProgress');
		var total    = dots.length;
		var current  = 0;
		var timer    = null;
		var pTimer   = null;
		var pVal     = 0;

		/* ── Navigation ── */
		function goTo(n) {
			current = ((n % total) + total) % total;
			track.style.transform = 'translateX(-' + (current * 100) + '%)';
			dots.forEach(function (d, i) {
			d.classList.toggle('active', i === current);
			});
			startProgress();
		}

		/* ── Barre de progression ── */
		function startProgress() {
			clearInterval(pTimer);
			clearTimeout(timer);
			pVal = 0;
			progress.style.transition = 'none';
			progress.style.width = '0%';

			var step = 100 / (AUTOPLAY_MS / 80);
			pTimer = setInterval(function () {
			pVal += step;
			progress.style.width = Math.min(pVal, 100) + '%';
			if (pVal >= 100) {
				clearInterval(pTimer);
				timer = setTimeout(function () { goTo(current + 1); }, 80);
			}
			}, 80);
		}

		/* ── Dots cliquables ── */
		dots.forEach(function (d) {
			d.addEventListener('click', function () {
			goTo(parseInt(d.getAttribute('data-index')));
			});
		});

		/* ── Swipe tactile ── */
		var touchStartX = 0;
		var touchStartY = 0;
		var dragging    = false;

		track.addEventListener('touchstart', function (e) {
			touchStartX = e.touches[0].clientX;
			touchStartY = e.touches[0].clientY;
			dragging = true;
		}, { passive: true });

		track.addEventListener('touchend', function (e) {
			if (!dragging) return;
			dragging = false;
			var dx = e.changedTouches[0].clientX - touchStartX;
			var dy = e.changedTouches[0].clientY - touchStartY;
			/* swipe Montserrattal uniquement (évite conflit scroll vertical) */
			if (Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 40) {
			dx < 0 ? goTo(current + 1) : goTo(current - 1);
			}
		}, { passive: true });

		/* ── Démarrage ── */
		goTo(0);

		})();
	</script>


</body>
</html>