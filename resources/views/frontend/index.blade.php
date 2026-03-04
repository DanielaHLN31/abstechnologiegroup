<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Accueil ABS-TECHNOLOGIE</title>
		@include('client.body.head')
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

	<!-- Slider -->
	<section class="section-slide">
		<div class="wrap-slick1">
			<div class="slick1">
				<!-- Slide 1 - Téléphonie -->
				<div class="item-slick1" style="background-image: url({{ asset('frontend/images/slide-1.png') }});">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Téléphonie Mobile
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
									Smartphones Samsung
								</h2>
								<p class="stext-113 cl2 p-b-30">
									Samsung Galaxy Z Fold5, Samsung Galaxy S24 Ultra et bien plus
								</p>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
								<a href="{{ route('client.product', ['category' => 'telephonie']) }}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Découvrir
								</a>
							</div>
						</div>
					</div>
				</div>

				<!-- Slide 2 - Informatique -->
				<div class="item-slick1" style="background-image: url({{ asset('frontend/images/slide-4.png') }});">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">

							<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Informatique
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
									Matériels informatiques
								</h2>
								<p class="stext-113 cl2 p-b-30">
									Découvrez nos Ordinateurs Portables & Accessoires de qualité.
								</p>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
								<a href="{{ route('client.product') }}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Voir les Produits
								</a>
							</div>

						</div>
					</div>
				</div>

				<!-- Slide 3 - Électronique / Électroménager -->
				<div class="item-slick1" style="background-image: url({{ asset('frontend/images/slide-2.png') }});">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Électroménager
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
									Équipements Domestiques
								</h2>
								<p class="stext-113 cl2 p-b-30">
									Réfrigérateurs, machines à laver, climatiseurs
								</p>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
								<a href="{{ route('client.product', ['category' => 'electromenager']) }}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Voir les Promos
								</a>
							</div>
						</div>
					</div>
				</div>

				<!-- Slide 4 - Support Technique -->
				<div class="item-slick1" style="background-image: url({{ asset('frontend/images/slide-3.png') }});">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Support Technique
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
									Assistance & Réparation
								</h2>
								<p class="stext-113 cl2 p-b-30">
									Service après-vente, réparation, maintenance
								</p>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
								<a href="{{ route('client.contact') }}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									Demander de l'Aide
								</a>
							</div>
						</div>
					</div>
				</div>

				
			</div>
		</div>
	</section>


	<!-- Banner -->
	<div class="sec-banner bg0 p-t-80 p-b-50">
		<div class="container">
			<div class="row">
				@foreach($categories->take(3) as $index => $category)
					@php
						// Images différentes selon l'index
						$bannerImages = [
							0 => '5.png',
							1 => '6.png', 
							2 => '7.png'
						];
						
						// Définir des slogans différents pour chaque catégorie
						$slogans = [
							0 => 'Spring 2018',
							1 => 'Spring 2018', 
							2 => 'New Trend'
						];
						
						// Couleurs de fond différentes (optionnel)
						$overlayColors = [
							0 => 'rgba(0,0,0,0.3)',
							1 => 'rgba(0,0,0,0.2)',
							2 => 'rgba(0,0,0,0.25)'
						];
					@endphp
					
					<div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
						<!-- Block1 -->
						<div class="block1 wrap-pic-w">
							@if($category->image)
								<img src="{{ asset('storage/' . $category->image) }}" 
									alt="{{ $category->name }}"
									style="min-height: 250px; object-fit: cover;">
							@else
								<img src="{{ asset('frontend/images/' . $bannerImages[$index]) }}" 
									alt="{{ $category->name }}">
							@endif

							<a href="{{ route('client.product', ['category' => $category->id]) }}" 
							class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
								<div class="block1-txt-child1 flex-col-l">
									<span class="block1-name ltext-102 trans-04 p-b-8">
										{{ $category->name }}
									</span>

									<span class="block1-info stext-102 trans-04" style="max-width: 210px">
										{{ $category->description ?? $slogans[$index] }}
									</span>
								</div>

								<div class="block1-txt-child2 p-b-4 trans-05">
									<div class="block1-link stext-101 cl0 trans-09">
										Commander <i class="fa fa-arrow-right m-l-8"></i>
									</div>
								</div>
							</a>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>


	<!-- Product -->
	<section class="bg0 p-t-23 p-b-140">
		<div class="container">
			<div class="p-b-10">
				<h3 class="ltext-103 cl5">
					Product Overview
				</h3>
			</div>
			<div class="flex-w flex-sb-m p-b-52">
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
						All Products
					</button>
					
					@foreach($categories->take(3) as $category)
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".cat-{{ $category->id }}">
						{{ $category->name }}
					</button>
					@endforeach
				</div>

			
			@include('frontend.filter')
			<div class="row isotope-grid">
				@forelse($products->take(12) as $product)
    				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item cat-{{ $product->category_id }}"
						data-brand-id="{{ $product->brand_id }}"
						data-colors="{{ json_encode($product->colors) }}">

					<!-- Block2 -->
					<div class="block2">
						<div class="block2-pic hov-img0">
							@if($product->images->isNotEmpty())
								<img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}">
							@else
								<img src="{{ asset('frontend/images/no-image.jpg') }}" alt="No Image">
							@endif

							<a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1" 
								data-product-id="{{ $product->id ?? '' }}"
								data-product-name="{{ $product->name ?? '' }}"
								data-product-price="{{ $product->price ?? '' }}"
								data-product-description="{{ $product->description ?? '' }}"
								data-product-images="{{ json_encode($product->images) }}"
								data-product-colors="{{ json_encode($product->colors) }}"
								data-product-specs="{{ json_encode($product->specifications) }}">
									Voir
							</a>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l">
								<a href="javascript:;" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
									{{ $product->name }}
								</a>

								<span class="stext-105 cl3">
									@if($product->compare_price && $product->compare_price > $product->price)
										<span class="text-decoration-line-through text-muted">{{ number_format($product->compare_price, 0, ',', ' ') }} FCFA</span>
										<span class="text-danger ml-2">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
									@else
										{{ number_format($product->price, 0, ',', ' ') }} FCFA
									@endif
								</span>
								
								@if($product->colors->isNotEmpty())
								<div class="mt-2">
									@foreach($product->colors->take(3) as $color)
									<span class="d-inline-block rounded-circle mr-1" 
										style="width: 15px; height: 15px; background-color: {{ $color->code }}; border: 1px solid #ddd;" 
										title="{{ $color->name }}"></span>
									@endforeach
									@if($product->colors->count() > 3)
									<span class="small text-muted">+{{ $product->colors->count() - 3 }}</span>
									@endif
								</div>
								@endif
							</div>

							<div class="block2-txt-child2 flex-r p-t-3">
								<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2" data-product-id="{{ $product->id }}">
									<img class="icon-heart1 dis-block trans-04" src="{{ asset('frontend/images/icons/icon-heart-01.png') }}" alt="ICON">
									<img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{ asset('frontend/images/icons/icon-heart-02.png') }}" alt="ICON">
								</a>
							</div>
						</div>
					</div>
				</div>
				@empty
				<div class="col-12 text-center p-t-50 p-b-50">
					<p class="stext-113 cl6">Aucun produit disponible pour le moment.</p>
				</div>
				@endforelse
			</div>

			<!-- Load more -->
			{{-- @if($products->count() > 12) --}}
			<div class="flex-c-m flex-w w-full p-t-45">
				<a href="{{route('client.product')}}" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04" id="load-more">
					Voir tous les produits
				</a>
			</div>
			{{-- @endif --}}
		</div>
	</section>

	@include('client.body.footer')
@include('frontend.productModal')


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
	<script src="{{ asset('frontend/js/product.js') }}"></script>

	@include('frontend.global_js')

</body>
</html>