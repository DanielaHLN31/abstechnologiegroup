<!DOCTYPE html>
<html lang="en">
<head>
    <title>Résultats recherche ABS-TECHNOLOGIE</title>
    @include('client.body.head')
</head>

<body class="animsition">
	<!-- Header -->@include('client.body.header')


<div class="container p-t-80 p-b-80">


    {{-- Titre --}}
    <div class="p-b-30 m-t-23">
        @if($query)
            <h3 class="ltext-103 cl5">
                Résultats pour <em>"{{ $query }}"</em>
                <span class="stext-107 cl6 m-l-10">— {{ $products->total() }} résultat{{ $products->total() > 1 ? 's' : '' }}</span>
            </h3>
        @else
            <h3 class="ltext-103 cl5">Tous les produits</h3>
        @endif
    </div>

    <div class="row">

        {{-- ── Sidebar filtres ────────────────────────────────── --}}
        <div class="col-lg-3 p-b-40">
            <form method="GET" action="{{ route('client.search') }}" id="filter-form">
                @if($query)
                    <input type="hidden" name="q" value="{{ $query }}">
                @endif

                {{-- Tri --}}
                <div class="filter-block p-b-25 m-b-25" style="border-bottom:1px solid #e6e6e6">
                    <div class="mtext-102 cl2 p-b-15">Trier par</div>
                    <select name="sort" class="form-control stext-107 cl6"
                            style="border:1px solid #e6e6e6;padding:8px 12px;border-radius:4px;width:100%"
                            onchange="document.getElementById('filter-form').submit()">
                        <option value="relevance"  {{ $sort === 'relevance'  ? 'selected' : '' }}>Pertinence</option>
                        <option value="newest"     {{ $sort === 'newest'     ? 'selected' : '' }}>Plus récents</option>
                        <option value="price_asc"  {{ $sort === 'price_asc'  ? 'selected' : '' }}>Prix croissant</option>
                        <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                    </select>
                </div>

                {{-- Catégorie --}}
                <div class="filter-block p-b-25 m-b-25" style="border-bottom:1px solid #e6e6e6">
                    <div class="mtext-102 cl2 p-b-15">Catégorie</div>
                    <ul class="filter-list" style="list-style:none;padding:0;margin:0">
                        <li class="p-b-8">
                            <label class="filter-check-label stext-106 cl6" style="display:flex;align-items:center;gap:8px;cursor:pointer">
                                <input type="radio" name="category" value=""
                                       {{ !$category ? 'checked' : '' }}
                                       onchange="this.form.submit()"
                                       style="accent-color:#0066cc">
                                Toutes
                            </label>
                        </li>
                        @foreach($categories as $cat)
                        <li class="p-b-8">
                            <label class="filter-check-label stext-106 cl6" style="display:flex;align-items:center;gap:8px;cursor:pointer">
                                <input type="radio" name="category" value="{{ $cat->id }}"
                                       {{ $category == $cat->id ? 'checked' : '' }}
                                       onchange="this.form.submit()"
                                       style="accent-color:#0066cc">
                                {{ $cat->name }}
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Marque --}}
                <div class="filter-block p-b-25 m-b-25" style="border-bottom:1px solid #e6e6e6">
                    <div class="mtext-102 cl2 p-b-15">Marque</div>
                    <ul class="filter-list" style="list-style:none;padding:0;margin:0">
                        <li class="p-b-8">
                            <label class="filter-check-label stext-106 cl6" style="display:flex;align-items:center;gap:8px;cursor:pointer">
                                <input type="radio" name="brand" value=""
                                       {{ !$brand ? 'checked' : '' }}
                                       onchange="this.form.submit()"
                                       style="accent-color:#0066cc">
                                Toutes
                            </label>
                        </li>
                        @foreach($brands as $b)
                        <li class="p-b-8">
                            <label class="filter-check-label stext-106 cl6" style="display:flex;align-items:center;gap:8px;cursor:pointer">
                                <input type="radio" name="brand" value="{{ $b->id }}"
                                       {{ $brand == $b->id ? 'checked' : '' }}
                                       onchange="this.form.submit()"
                                       style="accent-color:#0066cc">
                                {{ $b->name }}
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Prix --}}
                <div class="filter-block p-b-25">
                    <div class="mtext-102 cl2 p-b-15">Prix (FCFA)</div>
                    <div style="display:flex;gap:8px;align-items:center">
                        <input type="number" name="min_price" value="{{ $minPrice }}"
                               placeholder="Min"
                               class="stext-107 cl6"
                               style="width:50%;border:1px solid #e6e6e6;padding:7px 10px;border-radius:4px;font-size:13px">
                        <span class="cl6">—</span>
                        <input type="number" name="max_price" value="{{ $maxPrice }}"
                               placeholder="Max"
                               class="stext-107 cl6"
                               style="width:50%;border:1px solid #e6e6e6;padding:7px 10px;border-radius:4px;font-size:13px">
                    </div>
                    <button type="submit" class="flex-c-m stext-101 cl0 bg1 bor1 hov-btn1 p-lr-15 trans-04 m-t-12"
                            style="height:36px;border:none;cursor:pointer;width:100%;border-radius:4px">
                        Appliquer
                    </button>

                    @if($minPrice || $maxPrice || $category || $brand)
                        <a href="{{ route('client.search', ['q' => $query]) }}"
                           class="stext-107 cl6 hov-cl1 trans-04"
                           style="display:block;text-align:center;margin-top:10px;font-size:12px">
                            ✕ Réinitialiser les filtres
                        </a>
                    @endif
                </div>

            </form>
        </div>

        {{-- ── Grille produits ────────────────────────────────── --}}
        <div class="col-lg-9">

            @if($products->isEmpty())
                <div class="txt-center p-t-60 p-b-60">
                    <i class="zmdi zmdi-search" style="font-size:70px;color:#ddd;display:block;margin-bottom:16px"></i>
                    <p class="stext-113 cl6 p-b-16">
                        @if($query)
                            Aucun produit trouvé pour <strong>"{{ $query }}"</strong>.
                        @else
                            Aucun produit ne correspond à vos critères.
                        @endif
                    </p>
                    <p class="stext-107 cl6">Essayez avec d'autres mots-clés ou modifiez vos filtres.</p>
                    <a href="{{ route('client.product') }}"
                       class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 m-t-20"
                       style="display:inline-flex">
                        Voir tous les produits
                    </a>
                </div>

            @else
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-sm-6 col-md-4 p-b-35">
                        <div class="block2">

                            {{-- Image --}}
                            <div class="block2-pic hov-img0">
                                @if($product->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                         alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('frontend/images/no-image.jpg') }}" alt="no image">
                                @endif

                                <a href="#"
                                   class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1"
                                   data-product-id="{{ $product->id }}"
                                   data-product-name="{{ $product->name }}"
                                   data-product-price="{{ $product->price }}"
                                   data-product-description="{{ $product->description }}"
                                   data-product-images="{{ json_encode($product->images) }}"
                                   data-product-colors="{{ json_encode($product->colors) }}"
                                   data-product-specs="{{ json_encode($product->specifications ?? []) }}">
                                    Voir
                                </a>
                            </div>

                            {{-- Infos --}}
                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l">

                                    {{-- Mettre en gras le terme recherché dans le nom --}}
                                    <a href="javascript:;"
                                       class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                        @if($query)
                                            {!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark style="background:#fff3cd;padding:0 2px;border-radius:2px">$1</mark>', e($product->name)) !!}
                                        @else
                                            {{ $product->name }}
                                        @endif
                                    </a>

                                    <span class="stext-105 cl3">
                                        @if($product->compare_price && $product->compare_price > $product->price)
                                            <span style="text-decoration:line-through;color:#aaa;margin-right:6px">
                                                {{ number_format($product->compare_price, 0, ',', ' ') }} FCFA
                                            </span>
                                            <span style="color:#e65540;font-weight:600">
                                                {{ number_format($product->price, 0, ',', ' ') }} FCFA
                                            </span>
                                        @else
                                            {{ number_format($product->price, 0, ',', ' ') }} FCFA
                                        @endif
                                    </span>
                                </div>

                                {{-- Bouton wishlist --}}
                                <div class="block2-txt-child2 flex-r p-t-3">
                                    <a href="#"
                                       class="btn-addwish-b2 dis-block pos-relative js-addwish-b2"
                                       data-product-id="{{ $product->id }}">
                                        <img class="icon-heart1 dis-block trans-04"
                                             src="{{ asset('frontend/images/icons/icon-heart-01.png') }}" alt="ICON">
                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                             src="{{ asset('frontend/images/icons/icon-heart-02.png') }}" alt="ICON">
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                {{-- <div class="flex-c-m flex-w w-full p-t-45">
                    {{ $products->links('vendor.pagination.custom') }}
                </div> --}}
            @endif
        </div>

    </div>
</div>


@include('frontend.modal')
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


	@include('frontend.global_js')


</body>
</html>