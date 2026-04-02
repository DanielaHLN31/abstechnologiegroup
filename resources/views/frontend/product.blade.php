<!DOCTYPE html>
<html lang="en">
<head>
	<title>Boutique ABS-TECHNOLOGIE</title>
	@include('client.body.head')

  <style>
	
/* @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap'); */
	.hs-dropdown.open {
		display: none !important;
	}
  </style>
</head>
<body class="animsition">
	
	<!-- Header -->
	@include('client.body.header')

	@include('frontend.modal')

	
<section class="shop-hero">

    {{-- ── Gauche : titre + search + stats ── --}}
    <div class="shop-hero__left">

        <div class="shop-hero__pill">
            <span class="shop-hero__pill-dot"></span>
            Boutique officielle
        </div>

        <h1 class="shop-hero__title">
            Tous nos <span>produits</span> au <br>meilleur prix
        </h1>

        <p class="shop-hero__sub">
            Smartphones, informatique, électroménager —<br>
            livrés rapidement au cœur de Cotonou.
        </p>

        {{-- Barre de recherche (pointe vers la même route) --}}
        
		@include('frontend.hero-search')


    </div>

    {{-- ── Droite : raccourcis catégories (3 premières) ── --}}
    <div class="shop-hero__right">

        @php
            $heroIcons = [
                // SVG path pour chaque catégorie (téléphonie, informatique, électroménager)
                '<rect x="5" y="2" width="14" height="20" rx="2"/><line x1="9" y1="7" x2="15" y2="7"/><line x1="9" y1="11" x2="15" y2="11"/><circle cx="12" cy="16" r="1.2" fill="#0066CC" stroke="none"/>',
                '<rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>',
                '<path d="M3 6h18l-1.5 9H4.5L3 6z"/><path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"/><circle cx="9" cy="19" r="1.2" fill="#0066CC" stroke="none"/><circle cx="15" cy="19" r="1.2" fill="#0066CC" stroke="none"/>',
            ];
            $heroDescs = [
                'Smartphones & accessoires',
                'PC, portables & périphériques',
                'Appareils & climatisation',
            ];
        @endphp

        @foreach($categories->take(3) as $index => $cat)
        <a href="{{ route('client.product', ['category' => $cat->id]) }}" class="shop-hero__cat">
            <div class="shop-hero__cat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="#0066CC" stroke-width="1.8">
                    {!! $heroIcons[$index] ?? '<circle cx="12" cy="12" r="8"/>' !!}
                </svg>
            </div>
            <div>
                <span class="shop-hero__cat-name">{{ $cat->name }}</span>
                <span class="shop-hero__cat-desc">{{ $heroDescs[$index] ?? ($cat->description ?? 'Voir les produits') }}</span>
            </div>
        </a>
        @endforeach

    </div>

</section>

	<!-- Product -->
	<section class="ps-section">

		{{-- Header --}}
		<div class="ps-header">
			<div class="ps-section-accent"></div>
			<div class="ps-label">
				<span class="ps-label-dot"></span>
				Notre catalogue
			</div>
			<h2 class="ps-title">Nos <span>Produits</span></h2>
			<p class="ps-subtitle">Découvrez notre sélection complète de produits tech, high-end &amp; multimédia</p>
		</div>

		{{-- Filtres dynamiques (catégories depuis la BDD) --}}
		<div class="ps-filters">
			<button class="ps-filter-btn {{ is_null($activeCategory) ? 'active' : '' }}" data-filter="all">
				Tous les produits
			</button>

			@foreach($categories->take(6) as $cat)
			<button class="ps-filter-btn {{ $activeCategory == $cat->id ? 'active' : '' }}" data-filter="cat-{{ $cat->id }}">
				{{ $cat->name }}
			</button>
			@endforeach
		</div>

		{{-- Filtre avancé --}}
		@include('frontend.filter')

		{{-- Grille produits --}}
		<div class="ps-grid" id="psGrid">

			@forelse($products as $product)
			<div class="ps-card" data-cat="cat-{{ $product->category_id }}">

				{{-- Zone image --}}
				<div class="ps-card-img">

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

					{{-- Badge (Promo > Nouveau > Top Vente) --}}
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

					{{-- Aperçu rapide --}}
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

		{{-- Load more --}}
		@if($products->hasMorePages())
		<div class="ps-view-all">
			<a href="#" class="ps-view-all-btn" id="load-more"
				data-next-page="{{ $products->currentPage() + 1 }}"
				data-category="{{ request('category') }}">
				Voir plus de produits
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

<!--===============================================================================================-->	
	<script src="{{ asset('frontend/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/select2/select2.min.js') }}"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/slick/slick.min.js') }}"></script>
	<script src="{{ asset('frontend/js/slick-custom.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/parallax100/parallax100.js') }}"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/isotope/isotope.pkgd.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('frontend/vendor/sweetalert/sweetalert.min.js') }}"></script>
	
<!--===============================================================================================-->
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
<!--===============================================================================================-->
	<script src="{{ asset('frontend/js/main.js') }}"></script>

	@include('frontend.global_js')

</body>
</html>