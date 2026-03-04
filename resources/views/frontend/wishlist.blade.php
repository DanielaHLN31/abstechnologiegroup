<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mes favoris ABS-TECHNOLOGIE</title>
    @include('client.body.head')
    <style>
        /* Wishlist grid */
        #wishlist-grid {
            display: flex;
            flex-wrap: wrap;
        }

        .wishlist-card {
            display: flex;
            flex-direction: column;
        }

        .wishlist-card .block2 {
            display: flex;
            flex-direction: column;
            height: 100%;
            flex: 1;
        }

        /* Le bouton panier prend toute la largeur en bas */
        .wishlist-card .block2 > .p-t-15 {
            padding: 10px 14px 14px;
            background: #fff;
            margin-top: auto;
        }
    </style>
</head>

<body class="animsition">
	<!-- Header -->

    @include('client.body.header')
    @include('frontend.modal')

    <div class="container p-t-80 p-b-80">

        <h3 class="ltext-103 cl5 p-b-40">
            Mes Favoris
            @if($wishlistItems->isNotEmpty())
                <span class="stext-107 cl6 m-l-10">({{ $wishlistItems->count() }} article{{ $wishlistItems->count() > 1 ? 's' : '' }})</span>
            @endif
        </h3>

        @if($wishlistItems->isEmpty())
            {{-- Panier vide --}}
            <div class="txt-center p-t-40 p-b-60">
                <i class="zmdi zmdi-favorite-outline" style="font-size:80px;color:#ddd;display:block;margin-bottom:20px"></i>
                <p class="stext-113 cl6 p-b-20">Vous n'avez aucun produit dans vos favoris.</p>
                <a href="{{ route('client.product') }}"
                class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04"
                style="display:inline-flex">
                    Découvrir nos produits
                </a>
            </div>

        @else
        
            {{-- Actions globales --}}
            <div class="flex-w flex-sb-m p-t-40 p-t-18">
                <a href="{{ route('client.product') }}" class="stext-101 cl2 hov-cl1 trans-04 text-primary">
                    ← Continuer mes achats
                </a>
                <button id="btn-clear-wishlist" class="stext-101 cl2 hov-cl1 trans-04 btn btn-primary text-white">
                    <i class="zmdi zmdi-delete m-r-5"></i> Tout supprimer
                </button>
            </div>
            <!-- Product -->
            <section class="bg0 p-t-23 p-b-140">
                <div class="container">

                    <div class="row" id="wishlist-grid">
                        @foreach($wishlistItems as $item)
                        @php $product = $item->product; @endphp

                        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 wishlist-card" data-product-id="{{ $product->id }}">
                            <div class="block2">

                                {{-- Image --}}
                                <div class="block2-pic hov-img0" style="position:relative">
                                    @if($product->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                            alt="{{ $product->name }}">
                                    @else
                                        <img src="{{ asset('frontend/images/no-image.jpg') }}" alt="no image">
                                    @endif

                                    {{-- Quick View --}}
                                    <a href="#"
                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-price="{{ $product->price }}"
                                    data-product-description="{{ $product->description }}"
                                    data-product-images="{{ json_encode($product->images) }}"
                                    data-product-colors="{{ json_encode($product->colors) }}"
                                    data-product-specs="{{ json_encode($product->specifications ?? []) }}">
                                        voir
                                    </a>

                                    {{-- Bouton retirer des favoris --}}
                                    <button type="button"
                                            class="btn-remove-wishlist"
                                            data-product-id="{{ $product->id }}"
                                            title="Retirer des favoris"
                                            style="
                                                position:absolute;top:10px;right:10px;
                                                background:rgba(255,255,255,.9);
                                                border:none;border-radius:50%;
                                                width:34px;height:34px;
                                                display:flex;align-items:center;justify-content:center;
                                                cursor:pointer;box-shadow:0 2px 6px rgba(0,0,0,.12);
                                                font-size:16px;color:#e65540;
                                                transition:transform .2s;
                                            ">
                                        <i class="zmdi zmdi-favorite"></i>
                                    </button>
                                </div>

                                {{-- Infos produit --}}
                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l" style="flex:1">

                                        {{-- Catégorie --}}
                                        @if($product->category)
                                            <span class="stext-107" style="font-size:11px;color:#aaa;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px">
                                                {{ $product->category->name }}
                                            </span>
                                        @endif

                                        {{-- Nom --}}
                                        <a href="javascript:;"
                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            {{ $product->name }}
                                        </a>

                                        {{-- Prix --}}
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

                                        {{-- Stock --}}
                                        @if($product->stock_quantity <= 0)
                                            <span style="font-size:12px;color:#e65540;margin-top:4px">Rupture de stock</span>
                                        @elseif($product->stock_quantity <= $product->low_stock_threshold)
                                            <span style="font-size:12px;color:#f0ad4e;margin-top:4px">
                                                Plus que {{ $product->stock_quantity }} en stock
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Bouton Ajouter au panier --}}
                                {{-- <div class="p-t-15">
                                    @if($product->stock_quantity > 0)
                                        <button type="button"
                                                class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 w-full btn-addcart-wishlist"
                                                data-product-id="{{ $product->id }}"
                                                style="width:100%;border:none;cursor:pointer">
                                            <i class="zmdi zmdi-shopping-cart m-r-8"></i> Ajouter au panier
                                        </button>
                                    @else
                                        <button disabled
                                                class="flex-c-m stext-101 cl6 size-101 bg6 bor1 p-lr-15 w-full"
                                                style="width:100%;border:none;opacity:.5;cursor:not-allowed">
                                            Indisponible
                                        </button>
                                    @endif
                                </div> --}}

                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Load more -->
                    <div class="flex-c-m flex-w w-full p-t-45">
                        <a href="#" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                            Load More
                        </a>
                    </div>
                </div>
            </section>

        @endif

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

    @include('frontend.global_js')
    <script>
    $(document).ready(function () {
        const TOKEN = '{{ csrf_token() }}';

        /* ── Retirer un article des favoris ─────────────────────── */
        $(document).on('click', '.btn-remove-wishlist', function () {
            const productId = $(this).data('product-id');
            const $card     = $(this).closest('.wishlist-card');

            $.ajax({
                url: '{{ route("client.wishlist.remove") }}',
                method: 'POST',
                data: { product_id: productId, _token: TOKEN },
                success: function (res) {
                    $card.fadeOut(300, function () {
                        $(this).remove();
                        updateWishlistBadge(res.count);
                        if ($('.wishlist-card').length === 0) location.reload();
                    });
                },
                error: handleError
            });
        });

        /* ── Ajouter au panier depuis la wishlist ───────────────── */
        $(document).on('click', '.btn-addcart-wishlist', function () {
            const productId = $(this).data('product-id');
            const $btn      = $(this);

            $btn.text('Ajout...').prop('disabled', true);

            $.ajax({
                url: '{{ route("client.cart.add") }}',
                method: 'POST',
                data: { product_id: productId, quantity: 1, _token: TOKEN },
                success: function (res) {
                    $btn.html('<i class="zmdi zmdi-check m-r-8"></i> Ajouté !').prop('disabled', false);
                    setTimeout(() => {
                        $btn.html('<i class="zmdi zmdi-shopping-cart m-r-8"></i> Ajouter au panier');
                    }, 2000);
                    if (res.cart_count !== undefined) {
                        $('.js-show-cart').attr('data-notify', res.cart_count);
                    }
                },
                error: function (xhr) {
                    $btn.html('<i class="zmdi zmdi-shopping-cart m-r-8"></i> Ajouter au panier').prop('disabled', false);
                    handleError(xhr);
                }
            });
        });

        /* ── Vider toute la wishlist ────────────────────────────── */
        $('#btn-clear-wishlist').on('click', function () {
            swal({
                title: 'Vider les favoris ?',
                text: 'Tous vos favoris seront supprimés.',
                icon: 'warning',
                buttons: ['Annuler', 'Vider'],
                dangerMode: true,
            }).then(function (confirmed) {
                if (!confirmed) return;
                // Retirer tous les articles un par un via AJAX
                const requests = [];
                $('.wishlist-card').each(function () {
                    const pid = $(this).data('product-id');
                    requests.push($.ajax({
                        url: '{{ route("client.wishlist.remove") }}',
                        method: 'POST',
                        data: { product_id: pid, _token: TOKEN }
                    }));
                });
                Promise.all(requests.map(r => r.catch(() => null))).then(() => location.reload());
            });
        });

        /* ── Utilitaires ────────────────────────────────────────── */
        function updateWishlistBadge(count) {
            // Met à jour le badge de l'icône cœur dans le header
            $('[href="{{ route("client.wishlist") }}"].icon-header-noti').attr('data-notify', count > 0 ? count : '');
        }

        function handleError(xhr) {
            if (xhr.status === 401 && xhr.responseJSON?.redirect) {
                window.location.href = xhr.responseJSON.redirect;
            } else {
                const msg = xhr.responseJSON?.message || 'Une erreur est survenue.';
                swal('Erreur', msg, 'error');
            }
        }
    });
    </script>


</body>
</html>