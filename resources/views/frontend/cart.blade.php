<!DOCTYPE html>
<html lang="en">
<head>
	<title>Panier ABS-TECHNOLOGIE</title>
	@include('client.body.head')
</head>

<body class="animsition">
	<!-- Header -->
	@include('client.body.header')
	@include('frontend.modal')

	<div class="container p-t-80 p-b-80 m-t-150">

		@if($cartItems->isEmpty())
			<div class="txt-center p-t-60 p-b-60">
				<i class="zmdi zmdi-shopping-cart" style="font-size:80px;color:#ddd"></i>
				<p class="stext-113 cl6 p-t-20">Votre panier est vide.</p>
				<a href="{{ route('client.product') }}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 m-t-20" style="display:inline-flex">
					Continuer mes achats
				</a>
			</div>
		@else
		<div class="row">
			<!-- ── Tableau des articles ──────────────────────────────── -->
			<div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
				<div class="m-l-25 m-r--38 m-lr-0-xl">
					<table class="table-shopping-cart">
						<tr class="table_head">
							<th class="column-1">Produit</th>
							<th class="column-2"></th>
							<th class="column-3">Prix</th>
							<th class="column-4">Quantité</th>
							<th class="column-5">Total</th>
							<th class="column-6"></th>
						</tr>

						@foreach($cartItems as $item)
						<tr class="table_row cart-row" data-item-id="{{ $item->id }}">
							<!-- Image -->
							<td class="column-1">
								<div class="how-itemcart1">
									@if($item->product->images->isNotEmpty())
										<img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
											alt="{{ $item->product->name }}">
									@else
										<img src="{{ asset('frontend/images/no-image.jpg') }}" alt="no image">
									@endif
								</div>
							</td>

							<!-- Nom + couleur -->
							<td class="column-2">
								<span class="mtext-101 cl2">{{ $item->product->name }}</span>
								@if($item->color)
									<br>
									<span class="stext-107 cl6" style="display:flex;align-items:center;gap:5px;margin-top:4px">
										<span style="width:12px;height:12px;border-radius:50%;background:{{ $item->color->code }};border:1px solid #ddd;display:inline-block"></span>
										{{ $item->color->name }}
									</span>
								@endif
							</td>

							<!-- Prix unitaire -->
							<td class="column-3">
								<span class="mtext-101 cl2">
									{{ number_format($item->product->price, 0, ',', ' ') }} FCFA
								</span>
							</td>

							<!-- Quantité -->
							<td class="column-4">
								<div class="wrap-num-product flex-w m-l-auto m-r-0">
									<button type="button" class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m
											btn-qty-down" data-item-id="{{ $item->id }}">
										<i class="fs-16 zmdi zmdi-minus"></i>
									</button>
									<input class="mtext-104 cl3 txt-center num-product cart-qty-input"
										type="number"
										value="{{ $item->quantity }}"
										min="1"
										max="{{ $item->product->stock_quantity }}"
										data-item-id="{{ $item->id }}">
									<button type="button" class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m
											btn-qty-up" data-item-id="{{ $item->id }}">
										<i class="fs-16 zmdi zmdi-plus"></i>
									</button>
								</div>
							</td>

							<!-- Total ligne -->
							<td class="column-5">
								<span class="mtext-101 cl2 cart-line-total" data-item-id="{{ $item->id }}">
									{{ number_format($item->product->price * $item->quantity, 0, ',', ' ') }} FCFA
								</span>
							</td>

							<!-- Supprimer -->
							<td class="column-6">
								<button type="button" class="btn-remove-cart" data-item-id="{{ $item->id }}"
										style="background:none;border:none;color:#aaa;font-size:18px;cursor:pointer"
										title="Supprimer">
									<i class="zmdi zmdi-close"></i>
								</button>
							</td>
						</tr>
						@endforeach
					</table>

					<div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
						<a href="{{ route('client.product') }}" class="stext-101 cl2 hov-cl1 trans-04">
							← Continuer mes achats
						</a>
						<button id="btn-clear-cart" class="stext-101 cl2 hov-cl1 trans-04">
							Vider le panier
						</button>
					</div>
				</div>
			</div>

			<!-- ── Résumé commande ────────────────────────────────────── -->
			<div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
				<div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-lr-0-xl p-lr-15-sm">
					<h4 class="mtext-109 cl2 p-b-30">Récapitulatif</h4>

					<div class="flex-w flex-t bor12 p-b-13">
						<div class="size-208">
							<span class="stext-110 cl2">Sous-total :</span>
						</div>
						<div class="size-209">
							<span class="mtext-110 cl2" id="cart-subtotal">
								{{ number_format($subtotal, 0, ',', ' ') }} FCFA
							</span>
						</div>
					</div>

					<div class="flex-w flex-t bor12 p-t-15 p-b-30">
						<div class="size-208">
							<span class="stext-110 cl2">Livraison :</span>
						</div>
						<div class="size-209">
							<span class="stext-111 cl6">
								@if($subtotal >= 1000000)
									<span style="color:#5cb85c;font-weight:600">Gratuite 🎉</span>
								@else
									À calculer à la commande
								@endif
							</span>
						</div>
					</div>

					<div class="flex-w flex-t p-t-27 p-b-33">
						<div class="size-208">
							<span class="mtext-101 cl2">Total :</span>
						</div>
						<div class="size-209 p-t-1">
							<span class="mtext-110 cl2" id="cart-total">
								{{ number_format($subtotal, 0, ',', ' ') }} FCFA
							</span>
						</div>
					</div>

					<a href="{{ route('client.checkout') }}"
					class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
						Passer la commande
					</a>
				</div>
			</div>
		</div>
		@endif
	</div>


	@include('client.body.footer')


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

    /* ── Quantité : boutons +/- ─────────────────────────── */
    $(document).on('click', '.btn-qty-up, .btn-qty-down', function () {
        const itemId = $(this).data('item-id');
        const $input = $(`.cart-qty-input[data-item-id="${itemId}"]`);
        let qty = parseInt($input.val());
        const max = parseInt($input.attr('max'));

        if ($(this).hasClass('btn-qty-up')) {
            qty = Math.min(qty + 1, max);
        } else {
            qty = Math.max(qty - 1, 1);
        }

        $input.val(qty);
        updateQty(itemId, qty);
    });

    /* ── Quantité : saisie directe ──────────────────────── */
    $(document).on('change', '.cart-qty-input', function () {
        const itemId = $(this).data('item-id');
        let qty = parseInt($(this).val()) || 1;
        const max = parseInt($(this).attr('max'));
        qty = Math.min(Math.max(qty, 1), max);
        $(this).val(qty);
        updateQty(itemId, qty);
    });

    function updateQty(itemId, quantity) {
        $.ajax({
            url: '{{ route("client.cart.update") }}',
            method: 'POST',
            data: { item_id: itemId, quantity: quantity, _token: TOKEN },
            success: function (res) {
                $(`.cart-line-total[data-item-id="${itemId}"]`).text(res.line_total + ' FCFA');
                $('#cart-subtotal, #cart-total').text(res.subtotal + ' FCFA');
                updateHeaderCount(res.cart_count);
            },
            error: function () {
                swal('Erreur', 'Impossible de mettre à jour la quantité.', 'error');
            }
        });
    }

    /* ── Supprimer un article ───────────────────────────── */
    $(document).on('click', '.btn-remove-cart', function () {
        const itemId = $(this).data('item-id');
        const $row   = $(this).closest('.cart-row');

        $.ajax({
            url: '{{ route("client.cart.remove") }}',
            method: 'POST',
            data: { item_id: itemId, _token: TOKEN },
            success: function (res) {
                $row.fadeOut(300, function () {
                    $(this).remove();
                    if ($('.cart-row').length === 0) location.reload();
                });
                $('#cart-subtotal, #cart-total').text(res.subtotal + ' FCFA');
                updateHeaderCount(res.cart_count);
            },
            error: function () {
                swal('Erreur', 'Impossible de supprimer cet article.', 'error');
            }
        });
    });

    /* ── Vider le panier ────────────────────────────────── */
    $('#btn-clear-cart').on('click', function () {
        swal({
            title: 'Vider le panier ?',
            text: 'Tous les articles seront supprimés.',
            icon: 'warning',
            buttons: ['Annuler', 'Vider'],
            dangerMode: true,
        }).then(function (confirmed) {
            if (!confirmed) return;
            $.ajax({
                url: '{{ route("client.cart.clear") }}',
                method: 'POST',
                data: { _token: TOKEN },
                success: function () { location.reload(); },
                error: function () { swal('Erreur', 'Impossible de vider le panier.', 'error'); }
            });
        });
    });

    /* ── Mise à jour du badge header ────────────────────── */
    function updateHeaderCount(count) {
        $('.js-show-cart').attr('data-notify', count > 0 ? count : '');
    }
});
</script>



</body>
</html>