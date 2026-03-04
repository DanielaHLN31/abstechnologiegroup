<!DOCTYPE html>
<html lang="en">
<head>
	<title>Boutique ABS-TECHNOLOGIE</title>
	@include('client.body.head')
	<!--===============================================================================================-->
</head>
<body class="animsition">
	
	<!-- Header -->
	@include('client.body.header')


		@include('frontend.modal')

	{{-- <div class="mb-5"></div> --}}
	
	<!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-92 m-t-150" style="background-image: url('{{ asset('frontend/images/bg-01.png') }}');">
		<h2 class="ltext-105 cl0 txt-center">
			Nos produits
		</h2>
	</section>	

	<!-- Product -->
	<div class="bg0 m-t-23 p-b-140 mt-5">
		<div class="container">
			<div class="flex-w flex-sb-m p-b-52">
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ is_null($activeCategory) ? 'how-active1' : '' }}" 
						data-filter="*">
						All Products
					</button>
					
					@foreach($categories->take(3) as $category)
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ $activeCategory == $category->id ? 'how-active1' : '' }}" 
						data-filter=".cat-{{ $category->id }}">
						{{ $category->name }}
					</button>
					@endforeach
				</div>
			@include('frontend.filter')

			<div class="row isotope-grid">
				@forelse($products as $product)
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
			{{-- APRÈS --}}
			@if($products->hasMorePages())
			<div class="flex-c-m flex-w w-full p-t-45" id="load-more-wrap">
				<a href="#" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04" id="load-more"
				data-next-page="2"
				data-category="{{ request('category') }}">
					Voir plus
				</a>
			</div>
			@endif
		</div>
	</div>
		

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
	<script>
$(document).on('click', '#load-more', function (e) {
    e.preventDefault();

    const $btn      = $(this);
    const nextPage  = $btn.data('next-page');
    const category  = $btn.data('category') || '';

    // Feedback visuel
    $btn.text('Chargement...').css('pointer-events', 'none');

    $.ajax({
        url: '{{ route("client.product") }}',   // adapte si ta route diffère
        method: 'GET',
        dataType: 'json',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
        data: {
            page    : nextPage,
            category: category || undefined
        },
        success: function (res) {
            // Injecter les nouveaux produits dans la grille Isotope
            var $newItems = $(res.html);
            $('.isotope-grid').append($newItems).isotope('appended', $newItems);

            // Relancer Isotope pour bien placer les nouveaux éléments
            $('.isotope-grid').isotope('layout');

            if (res.has_more) {
                $btn.data('next-page', res.next_page)
                    .text('Voir plus')
                    .css('pointer-events', '');
            } else {
                // Plus de produits : cacher le bouton
                $('#load-more-wrap').fadeOut(300, function () { $(this).remove(); });
            }
        },
        error: function () {
            $btn.text('Voir plus').css('pointer-events', '');
            toastr.error('Impossible de charger plus de produits.', 'Erreur');
        }
    });
});
</script>
</body>
</html>