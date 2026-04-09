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


		</style>
		<style>
			/* ── Hero refondu : badge, phrase principale, liste élégante ── */
			.hero-badge {
				display: inline-flex;
				align-items: center;
				gap: 8px;
				font-size: 11px;
				font-weight: 700;
				letter-spacing: 0.1em;
				text-transform: uppercase;
				color: #0066CC;
				background: rgba(0, 102, 204, 0.08);
				border: 1px solid rgba(0, 102, 204, 0.2);
				border-radius: 100px;
				padding: 5px 16px;
			}

			.hero-badge-dot {
				width: 6px;
				height: 6px;
				border-radius: 50%;
				background: #0066CC;
				animation: badgePulse 1.8s ease-in-out infinite;
			}

			@keyframes badgePulse {
				0%, 100% { transform: scale(1); opacity: 1; }
				50% { transform: scale(1.6); opacity: 0.5; }
			}

			.hero-main-title {
				font-size: clamp(28px, 4vw, 44px);
				font-weight: 800;
				line-height: 1.2;
				letter-spacing: -0.02em;
				color: #0a1628;
				text-align: center;
			}

			.hero-sub {
				font-size: 15px;
				color: #6b7a99;
				max-width: 480px;
				line-height: 1.5;
			}

			/* ── Liste des fonctionnalités (sous-phrases) ── */
			/* ── Liste des fonctionnalités (sous-phrases) en grille 2x2 ── */
			.hero-features {
				display: grid;
				grid-template-columns: repeat(2, 1fr);
				gap: 12px;
				max-width: 95%;
			}

			.hero-feature-item {
				display: flex;
				align-items: center;
				gap: 12px;
				padding: 12px 16px;
				background: #fff;
				border: 1.5px solid rgba(0, 102, 204, 0.08);
				border-radius: 8px;
				cursor: pointer;
				transition: all 0.25s cubic-bezier(0.34, 1.2, 0.64, 1);
			}

			/* Version compacte pour les écrans moyens */
			@media (max-width: 768px) {
				.hero-features {
					gap: 10px;
				}
				
				.hero-feature-item {
					padding: 10px 12px;
				}
				
				.hero-feature-icon {
					width: 32px;
					height: 32px;
				}
				
				.hero-feature-label {
					font-size: 14px;
				}
				
				.hero-feature-desc {
					font-size: 11px;
				}
			}

			/* Sur mobile, repasser en colonne unique */
			@media (max-width: 480px) {
				.hero-features {
					grid-template-columns: 1fr;
					gap: 8px;
				}
			}
			/* .hero-feature-item {
				display: flex;
				align-items: center;
				gap: 12px;
				padding: 10px 14px;
				background: #fff;
				border: 1.5px solid rgba(0, 102, 204, 0.08);
				border-radius: 8px;
				cursor: pointer;
				transition: all 0.25s cubic-bezier(0.34, 1.2, 0.64, 1);
			} */

			.hero-feature-item:hover {
				border-color: rgba(0, 102, 204, 0.3);
				transform: translateX(6px);
				background: #fafcff;
			}

			.hero-feature-item.active {
				/* border-color: #ffffff; */
				background: #0066ccca;
				box-shadow: 0 6px 14px rgba(0, 102, 204, 0.08);
			}

			.hero-feature-icon {
				width: 30px;
				height: 30px;
				border-radius: 6px;
				background: rgba(0, 102, 204, 0.08);
				display: flex;
				align-items: center;
				justify-content: center;
				flex-shrink: 0;
				color: #0066CC;
				transition: all 0.2s;
			}

			.hero-feature-item.active .hero-feature-icon {
				background: #fff;
				color: #0066CC;
			}

			.hero-feature-text {
				flex: 1;
			}

			.hero-feature-label {
				display: block;
				font-size: 16px;
				font-weight: 700;
				color: #0a1628;
				/* margin-bottom: 2px; */
			}

			.hero-feature-item.active .hero-feature-label {
				color: #fff;
			}

			.hero-feature-desc {
				font-size: 12px;
				color: #6b7a99;
			}


			.hero-feature-item.active .hero-feature-desc {
				color: #fff;
			}
			/* ── Images droite avec légende sous chaque image ── */
			.hero-img-wrap {
				position: relative;
				width: 100%;
				height: 420px;
			}

			.hero-slide-card {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				opacity: 0;
				transition: opacity 0.4s ease;
				display: flex;
				flex-direction: column;
				align-items: center;
				justify-content: center;
			}

			.hero-slide-card.active {
				opacity: 1;
				z-index: 2;
			}

			.hero-slide-card img {
				width: 100%;
				height: 500px;
				object-fit: contain;
				filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.12));
			}

			/* .hero-slide-caption {
				margin-top: 12px;
				display: inline-flex;
				align-items: center;
				gap: 8px;
				background: #fff;
				border: 1.5px solid rgba(0, 102, 204, 0.15);
				border-radius: 100px;
				padding: 6px 20px;
				font-size: 12px;
				font-weight: 700;
				color: #0a1628;
				letter-spacing: 0.05em;
				text-transform: uppercase;
				box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
			} */

			.hero-caption-dot {
				width: 8px;
				height: 8px;
				border-radius: 50%;
				display: inline-block;
			}

			/* ── Responsive ── */
			@media (max-width: 991px) {
				.hero-img-wrap {
					height: 320px;
					margin-top: 30px;
				}
				
				.hero-slide-card img {
					height: 260px;
				}
				
				.hero-features {
					max-width: 100%;
				}
			}

			@media (max-width: 768px) {
				.hero-header .col-lg-5 {
					display: block !important;
				}
				
				.hero-img-wrap {
					height: 280px;
				}
				
				.hero-slide-card img {
					height: 220px;
				}
				
				.hero-feature-item {
					padding: 10px 14px;
				}
				
				.hero-feature-icon {
					width: 38px;
					height: 38px;
				}
			}

			@media (max-width: 576px) {
				.hero-img-wrap {
					display: none;
				}
				
				.hero-feature-desc {
					font-size: 11px;
				}
			}

			.hs-wrap { max-width: 700px !important;}
			.hs-btn { padding: 0 48px !important; }
			/* Légende minimaliste sous chaque image */
			/* .hero-slide-caption {
				position: absolute;
				bottom: -40px;
				left: 50%;
				transform: translateX(-50%);
				background: rgb(255, 255, 255);
				backdrop-filter: blur(8px);
				border-radius: 10px;
				padding: 8px 20px;
				color: rgb(0, 0, 0);
				font-size: 13px;
				font-weight: 600;
				letter-spacing: 0.5px;
				white-space: nowrap;
				z-index: 10;
				opacity: 0;
				transition: opacity 0.3s ease;
			} */

			/* .hero-slide-card.active .hero-slide-caption {
				opacity: 1;
			} */

			/* Version mobile */
			@media (max-width: 768px) {
				.hero-slide-caption {
					font-size: 10px;
					padding: 5px 14px;
					bottom: 10px;
					white-space: nowrap;
				}
			}

			@media (max-width: 576px) {
				.hero-slide-caption {
					display: none;
				}
			}

			/* Légende visible et percutante */
			.hero-slide-caption {
				position: absolute;
				bottom: -20px;
				left: 0;
				right: 0;
				background: linear-gradient(90deg, #0066CC, #b80505);
				padding: 12px 20px;
				color: white;
				font-size: 14px;
				font-weight: 700;
				text-align: center;
				letter-spacing: 1px;
				text-transform: uppercase;
				transform: translateY(100%);
				transition: transform 0.3s ease;
				z-index: 10;
			}

			.hero-slide-card.active .hero-slide-caption {
				transform: translateY(0);
			}
		</style>

		<style>
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



	@include('frontend.partials.modal')

	<!-- Hero Start -->
	<div class="container-fluid py-5 hero-header" style="max-height: 550px">
		<div class="container mt-3">
			<div class="row g-5 align-items-center">

				{{-- Colonne gauche : contenu statique --}}
				<div class="col-md-12 col-lg-7" style="margin-top: 0 !important">
					
					
					<h6 class="mb-3 hero-tag" id="heroTag" style="color: #000">Technologie - Fiabilité - Innovation & Impact</h6>

					{{-- Phrase principale percutante --}}
					<h1 class="hero-main-title mb-3 text-primary">
						Distributeur Officiel <span class="text-secondary">Samsung au Bénin</span> 
					</h1>


					{{-- Liste des sous-phrases (statique mais interactive) --}}
					<div class="hero-features mb-4">
						{{-- <div class="d-flex "> --}}
							<div class="hero-feature-item active" data-slide="0">
								<div class="hero-feature-icon">
									<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
										<line x1="16" y1="21" x2="16" y2="15"></line>
										<line x1="8" y1="21" x2="8" y2="15"></line>
										<line x1="9" y1="11" x2="7" y2="11"></line>
										<line x1="17" y1="11" x2="15" y2="11"></line>
									</svg>
								</div>
								<div class="hero-feature-text">
									<span class="hero-feature-label"> <span style="color: #b80505">N°1 </span> en Électroménager</span>
									{{-- <span class="hero-feature-desc">Téléviseurs, clims, réfrigérateurs & cuisinières</span> --}}
								</div>
							</div>

							<div class="hero-feature-item" data-slide="1">
								<div class="hero-feature-icon">
									<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
										<line x1="12" y1="18" x2="12" y2="18"></line>
									</svg>
								</div>
								<div class="hero-feature-text">
									<span class="hero-feature-label"><span style="color: #b80505">N°1</span> en Téléphonie Mobile</span>
									{{-- <span class="hero-feature-desc">Galaxy haut de gamme & accessoires</span> --}}
								</div>
							</div>
						{{-- </div> --}}
						{{-- <div class="d-flex"> --}}
							<div class="hero-feature-item" data-slide="2">
								<div class="hero-feature-icon">
									<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect>
										<line x1="9" y1="4" x2="9" y2="20"></line>
										<line x1="15" y1="4" x2="15" y2="20"></line>
										<line x1="4" y1="9" x2="20" y2="9"></line>
										<line x1="4" y1="15" x2="20" y2="15"></line>
									</svg>
								</div>
								<div class="hero-feature-text">
									<span class="hero-feature-label"><span style="color: #b80505">N°1</span> en Matériels &amp; Accessoires Informatiques</span>
									{{-- <span class="hero-feature-desc">PC portables, fixes & périphériques pro</span> --}}
								</div>
							</div>

							<div class="hero-feature-item" data-slide="3">
								<div class="hero-feature-icon">
									<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
										<polyline points="22 4 12 14.01 9 11.01"></polyline>
									</svg>
								</div>
								<div class="hero-feature-text">
									<span class="hero-feature-label">Service Après Vente — SAV</span>
									{{-- <span class="hero-feature-desc">12 mois de garantie, support certifié</span> --}}
								</div>
							</div>
						{{-- </div> --}}
					</div>
					
					{{-- Barre de recherche / CTA rapide --}}
					@include('frontend.partials.hero-search')
				</div>

				{{-- Colonne droite : carousel images avec légende --}}
				<div class="col-md-12 col-lg-5" style="margin-top: 0 !important">
					<div class="hero-img-wrap">

						{{-- Slide 0 : Électroménager --}}
						<div class="hero-slide-card active" data-slide="0">
							<img src="{{ asset('frontend/images/slide2.png') }}" 
								alt="Électroménager Samsung"
								width="800" height="500"
								loading="eager">
							<div class="hero-slide-caption">
								<span class="hero-caption-dot" style="background: #0066CC;"></span>
								Électroménager
							</div>
						</div>

						{{-- Slide 1 : Smartphones --}}
						<div class="hero-slide-card" data-slide="1">
							<img src="{{ asset('frontend/images/slide1.png') }}" 
								alt="Smartphones Samsung"
								width="800" height="500"
								loading="lazy">
							<div class="hero-slide-caption">
								<span class="hero-caption-dot" style="background: #b80505;"></span>
								Téléphonie Mobile
							</div>
						</div>

						{{-- Slide 2 : Informatique --}}
						<div class="hero-slide-card" data-slide="2">
							<img src="{{ asset('frontend/images/slide3.png') }}" 
								alt="Informatique Samsung"
								width="800" height="500"
								loading="lazy">
							<div class="hero-slide-caption">
								<span class="hero-caption-dot" style="background: #f0ad4e;"></span>
								Informatique & Accessoires
							</div>
						</div>

						{{-- Slide 3 : SAV --}}
						<div class="hero-slide-card" data-slide="3">
							<img src="{{ asset('frontend/images/slide5.png') }}" 
								alt="Service Après-Vente"
								width="800" height="500"
								loading="lazy">
							<div class="hero-slide-caption">
								<span class="hero-caption-dot" style="background: #28a745;"></span>
								Service Après Vente — SAV & Livraison
							</div>
						</div>

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
			<span class="abs-marquee__item">Livraison Bénin <span class="abs-marquee__sep">·</span></span>
			{{-- duplicate for infinite loop --}}
			@foreach($categories->take(6) as $cat)
				<span class="abs-marquee__item">{{ $cat->name }} <span class="abs-marquee__sep">·</span></span>
			@endforeach
			<span class="abs-marquee__item">Support Technique <span class="abs-marquee__sep">·</span></span>
			<span class="abs-marquee__item">Livraison Bénin <span class="abs-marquee__sep">·</span></span>
		</div>
	</div>

	
	{{-- ══════════════ SECTION À PROPOS ══════════════ --}}
	<section class="about-abs-section">
	<div class="about-abs-inner">

		{{-- Colonne gauche : carousel galerie --}}
		<div class="about-abs-left">
			<div class="about-abs-carousel-wrap"> 
				<div class="about-abs-carousel" id="aboutCarousel">

					{{-- Slide 1 --}}
					<div class="about-abs-slide active" data-index="0">
					<img src="{{ asset('frontend/images/about1.jpeg') }}" alt="ABS Technologie galerie 1" loading="lazy">
					</div>

					{{-- Slide 2 --}}
					<div class="about-abs-slide" data-index="1">
					<img src="{{ asset('frontend/images/slide00.jpg') }}" alt="ABS Technologie galerie 2" loading="lazy">
					</div>

					{{-- Slide 2 --}}
					<div class="about-abs-slide" data-index="2">
					<img src="{{ asset('frontend/images/about2.jpeg') }}" alt="ABS Technologie galerie 2" loading="lazy">
					</div>

					{{-- Slide 3 --}}
					<div class="about-abs-slide" data-index="3">
					<img src="{{ asset('frontend/images/about3.jpeg') }}" alt="ABS Technologie galerie 3" loading="lazy">
					</div>

					{{-- Slide 4 --}}
					<div class="about-abs-slide" data-index="4">
					<img src="{{ asset('frontend/images/about4.jpeg') }}" alt="ABS Technologie galerie 4" loading="lazy">
					</div>

					<div class="about-abs-slide" data-index="5">
					<img src="{{ asset('frontend/images/about5.jpeg') }}" alt="ABS Technologie galerie 4" loading="lazy">
					</div>
					
					<div class="about-abs-slide" data-index="6">
					<img src="{{ asset('frontend/images/about6.jpeg') }}" alt="ABS Technologie galerie 5" loading="lazy">
					</div>
					
					<div class="about-abs-slide" data-index="7">
					<img src="{{ asset('frontend/images/about7.jpeg') }}" alt="ABS Technologie galerie 6" loading="lazy">
					</div>
					
					<div class="about-abs-slide" data-index="8">
					<img src="{{ asset('frontend/images/about8.jpeg') }}" alt="ABS Technologie galerie 7" loading="lazy">
					</div>
					
					<div class="about-abs-slide" data-index="9">
					<img src="{{ asset('frontend/images/about9.jpeg') }}" alt="ABS Technologie galerie 8" loading="lazy">
					</div>
					

					<button class="about-abs-nav prev" id="aboutPrev">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
					</button>
					<button class="about-abs-nav next" id="aboutNext">
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
					</button>

					<div class="about-abs-dots" id="aboutDots">
					<button class="about-abs-dot active" data-i="0"></button>
					<button class="about-abs-dot" data-i="1"></button>
					<button class="about-abs-dot" data-i="2"></button>
					<button class="about-abs-dot" data-i="3"></button>
					<button class="about-abs-dot" data-i="4"></button>
					<button class="about-abs-dot" data-i="5"></button>
					<button class="about-abs-dot" data-i="6"></button>
					<button class="about-abs-dot" data-i="7"></button>
					<button class="about-abs-dot" data-i="8"></button>
					<button class="about-abs-dot" data-i="9"></button>
					</div>
				</div>

				{{-- <div class="about-abs-badge">
					<div class="about-abs-badge-num">+20 ans</div>
					<div class="about-abs-badge-label">d'expérience au Bénin</div>
				</div> --}}
			</div>
		</div>

		{{-- Colonne droite : texte --}}
		<div class="about-abs-right">
		<div class="about-abs-label">À propos de nous</div>
		<h2 class="about-abs-title">Votre Partenaire Tech <span>de Confiance</span> au Bénin</h2>
		<p class="about-abs-desc">
			ABS-Technologie est le Distributeur Officiel Samsung au Bénin. Nous mettons à votre disposition des Produits Certifiés — Smartphones, Electroménager, Informatique — avec un Service Après-Vente de qualité. Notre objectif : vous offrir une expérience d'achat Fiable, Rapide et Accessible.
		</p>
		<p class="about-abs-desc">
			Que vous soyez Particulier ou Professionnel, nous proposons des Solutions Adaptées à vos Besoins avec une Garantie Officielle Samsung et une Livraison partout au Bénin.
		</p>

		<div class="about-abs-features">
			<div class="about-abs-feature"><span class="about-abs-check">✓</span> Produits Certifiés Samsung</div>
			<div class="about-abs-feature"><span class="about-abs-check">✓</span> Livraison partout au Bénin</div>
			<div class="about-abs-feature"><span class="about-abs-check">✓</span> SAV &amp; Garantie Officielle</div>
			<div class="about-abs-feature"><span class="about-abs-check">✓</span> Support Technique Expert</div>
		</div>

		<a href="{{ route('client.about') }}" class="about-abs-cta">
			En savoir plus
			<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
		</a>
		</div>

	</div>
	</section>
	
	{{-- ══════════════ ARTICLES EN VEDETTE ══════════════ --}}
	@if($featured->isNotEmpty())
	<section class="fv-section">
		<div class="fv-head">
			<div class="fv-accent"></div>
			<div class="fv-pill">
				<svg class="fv-star-icon" viewBox="0 0 24 24" width="12" height="12">
					<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="currentColor"/>
				</svg>
				Sélection Premium
			</div>
			<h2 class="fv-title">Articles en vedette <span>Samsung</span></h2>
			<p class="fv-sub">Nos coups de cœur, meilleures ventes &amp; exclusivités Samsung</p>
		</div>

		<div class="fv-owl-container">
			<div class="owl-carousel fv-owl-carousel owl-theme" id="fvCarousel">
				@foreach($featured as $index => $product)
				<div class="fv-card">
					<div class="fv-badge">
						<svg viewBox="0 0 24 24" width="10" height="10" style="fill:#fff;flex-shrink:0">
							<path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
						</svg>
						{{ $index === 0 ? 'SAMSUNG' : 'SAMSUNG' }}
					</div>

					<button class="fv-wish ps-wish js-addwish-b2" data-product-id="{{ $product->id }}" title="Ajouter aux favoris">
						<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#CC1B1B" stroke-width="2">
							<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
						</svg>
					</button>

					<a href="{{ route('client.detail.product', $product->id) }}" class="fv-img-link">
						<div class="fv-img-zone">
							@if($product->images->isNotEmpty())
								<img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
									alt="{{ $product->name }}"
									loading="{{ $index < 3 ? 'eager' : 'lazy' }}"
									decoding="async">
							@else
								<img src="{{ asset('frontend/images/no-image.jpg') }}"
									alt="{{ $product->name }}"
									loading="lazy">
							@endif
							<div class="fv-quickview js-show-modal1"
								data-product-id="{{ $product->id }}"
								data-product-name="{{ $product->name }}"
								data-product-price="{{ $product->price }}"
								data-product-images="{{ json_encode($product->images) }}"
								data-product-colors="{{ json_encode($product->colors) }}">
								Aperçu rapide
							</div>
						</div>
					</a>

					<div class="fv-body">
						<div class="fv-cat">{{ $product->category->name ?? 'Produit' }}</div>
						<a href="{{ route('client.detail.product', $product->id) }}" class="fv-name-link">
							<div class="fv-name">{{ $product->name }}</div>
						</a>
						<div class="fv-footer">
							<div class="fv-price">
								@if($product->compare_price && $product->compare_price > $product->price)
									@php $disc = round((1 - $product->price / $product->compare_price) * 100); @endphp
									<span class="fv-price-old">{{ number_format($product->compare_price, 0, ',', ' ') }} F</span>
									<span class="fv-price-main">{{ number_format($product->price, 0, ',', ' ') }} F</span>
									<span class="fv-disc-badge">-{{ $disc }}%</span>
								@else
									<span class="fv-price-main">{{ number_format($product->price, 0, ',', ' ') }} F</span>
								@endif
							</div>
							<button class="fv-btn abs-add-to-cart"
								data-product-id="{{ $product->id }}"
								data-product-name="{{ $product->name }}"
								data-product-price="{{ $product->price }}">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="12" height="12" stroke-width="2.5">
									<path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
									<line x1="3" y1="6" x2="21" y2="6"/>
									<path d="M16 10a4 4 0 01-8 0"/>
								</svg>
								Ajouter
							</button>
						</div>
					</div>
				</div>
				@endforeach
			</div>

			<!-- Autoplay control personnalisé -->
			{{-- <button class="fv-autoplay-control" id="fvAutoplayToggle" aria-label="Pause/Play autoplay">
				<svg class="pause-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" stroke-width="2.5">
					<rect x="6" y="4" width="4" height="16"/>
					<rect x="14" y="4" width="4" height="16"/>
				</svg>
				<svg class="play-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" stroke-width="2.5" style="display: none;">
					<polygon points="5 3 19 12 5 21 5 3"/>
				</svg>
			</button> --}}
		</div>

		{{-- <div class="fv-cta">
			<a href="{{ route('client.product') }}?featured=1" class="fv-cta-btn">
				Voir tous les articles vedette
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="14" height="14" stroke-width="2.5">
					<path d="M5 12h14M12 5l7 7-7 7"/>
				</svg>
			</a>
		</div> --}}
	</section>
	@endif

	
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

		{{-- Filtres dynamiques --}}
		<div class="ps-filters-sticky-wrap" id="psFiltersWrap">
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
		</div>

		{{-- Grille produits --}}
		<div class="ps-grid" id="psGrid">

			@forelse($products->take(12) as $product)
			<div class="ps-card" data-cat="cat-{{ $product->category_id }}">

				{{-- Zone image --}}
				<a href="{{ route('client.detail.product', $product->id) }}" class="ps-card-img-link">
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
				</a>
				{{-- Corps --}}
				<div class="ps-card-body">
					<span class="ps-card-cat">
						{{ $product->category->name ?? 'Produit' }}
					</span>

					<a href="{{ route('client.detail.product', $product->id) }}" class="ps-card-name-link">
						<div class="ps-card-name">{{ $product->name }}</div>
					</a>
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
	@include('frontend.partials.productModal')

	@include('frontend.script.js_links')

	{{-- ═══ SCRIPT CARROUSEL VEDETTE AVEC OWL CAROUSEL ═══ --}}
	<script>
		$(document).ready(function() {
			var owl = $('.fv-owl-carousel');
			var isAutoPlaying = true;
			
			// Initialisation Owl Carousel
			owl.owlCarousel({
				loop: true,                    // Boucle infinie
				margin: 24,                    // Marge entre les cartes
				nav: true,                     // Afficher les flèches
				navText: [
					'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="20" height="20" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>',
					'<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="20" height="20" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>'
				],
				dots: true,                    // Afficher les dots
				autoplay: true,                // Autoplay activé
				autoplayTimeout: 3000,         // 3 secondes entre chaque slide
				autoplayHoverPause: true,      // Pause au survol
				autoplaySpeed: 800,            // Vitesse de transition
				smartSpeed: 800,               // Vitesse intelligente
				responsive: {
					0: {
						items: 1,              // 1 carte sur mobile
						margin: 16,
						nav: false             // Pas de flèches sur mobile
					},
					576: {
						items: 2,              // 2 cartes sur tablette
						margin: 20
					},
					768: {
						items: 3,              // 3 cartes sur desktop
						margin: 24
					},
					1024: {
						items: 4,              // 4 cartes sur grand écran
						margin: 24
					},
					1280: {
						items: 4,              // 4 cartes maximum
						margin: 24
					}
				}
			});
			
			// Contrôle autoplay personnalisé
			var $autoplayToggle = $('#fvAutoplayToggle');
			var $pauseIcon = $autoplayToggle.find('.pause-icon');
			var $playIcon = $autoplayToggle.find('.play-icon');
			
			$autoplayToggle.on('click', function() {
				if (isAutoPlaying) {
					owl.trigger('stop.owl.autoplay');
					$pauseIcon.hide();
					$playIcon.show();
					isAutoPlaying = false;
				} else {
					owl.trigger('play.owl.autoplay', [3000]);
					$pauseIcon.show();
					$playIcon.hide();
					isAutoPlaying = true;
				}
			});
			
			// Optionnel: Sauvegarder l'état après interaction avec les flèches
			owl.on('changed.owl.carousel', function() {
				if (isAutoPlaying) {
					// Réinitialiser l'autoplay après navigation manuelle
					owl.trigger('stop.owl.autoplay');
					owl.trigger('play.owl.autoplay', [3000]);
				}
			});
		});
	</script>

	{{-- ═══ SCRIPT HERO CAROUSEL ═══ --}}
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const featureItems = document.querySelectorAll('.hero-feature-item');
			const slides = document.querySelectorAll('.hero-slide-card');
			let currentIndex = 0;
			let interval;

			function activateSlide(index) {
				// Mise à jour des sous-phrases
				featureItems.forEach((item, i) => {
					if (i === index) {
						item.classList.add('active');
					} else {
						item.classList.remove('active');
					}
				});
				
				// Mise à jour des images
				slides.forEach((slide, i) => {
					if (i === index) {
						slide.classList.add('active');
					} else {
						slide.classList.remove('active');
					}
				});
				
				currentIndex = index;
			}

			// Clic sur une sous-phrase
			featureItems.forEach((item, index) => {
				item.addEventListener('click', function() {
					activateSlide(index);
					resetAutoplay();
				});
			});

			// Autoplay toutes les 3 secondes
			function startAutoplay() {
				interval = setInterval(() => {
					let next = (currentIndex + 1) % slides.length;
					activateSlide(next);
				}, 3500);
			}

			function resetAutoplay() {
				clearInterval(interval);
				startAutoplay();
			}

			startAutoplay();

			// Pause au survol du bloc hero
			const heroSection = document.querySelector('.hero-header');
			heroSection.addEventListener('mouseenter', () => clearInterval(interval));
			heroSection.addEventListener('mouseleave', startAutoplay);
		});
	</script>

	<script>
		(function(){
		const slides = document.querySelectorAll('.about-abs-slide');
		const dots = document.querySelectorAll('.about-abs-dot');
		let cur = 0, timer;
		function go(n){ slides[cur].classList.remove('active'); dots[cur].classList.remove('active'); cur = (n + slides.length) % slides.length; slides[cur].classList.add('active'); dots[cur].classList.add('active'); }
		function startAuto(){ timer = setInterval(() => go(cur+1), 3500); }
		function resetAuto(){ clearInterval(timer); startAuto(); }
		document.getElementById('aboutPrev').addEventListener('click', () => { go(cur-1); resetAuto(); });
		document.getElementById('aboutNext').addEventListener('click', () => { go(cur+1); resetAuto(); });
		document.querySelectorAll('.about-abs-dot').forEach(d => d.addEventListener('click', () => { go(+d.dataset.i); resetAuto(); }));
		const c = document.getElementById('aboutCarousel');
		c.addEventListener('mouseenter', () => clearInterval(timer));
		c.addEventListener('mouseleave', startAuto);
		startAuto();
		})();
	</script>

</body>
</html>