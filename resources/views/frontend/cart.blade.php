<!DOCTYPE html>
<html lang="en">
<head>
	<title>Panier ABS-TECHNOLOGIE</title>
	@include('client.body.head')
	
	<style>
		/* Styles personnalisés pour la page panier */
		.cart-container {
			max-width: 1400px;
			margin: 0 auto;
			padding: 40px 20px;
			margin-top: 85px;
			font-family: 'Montserrat-Regular';
		}
		
		.cart-header {
			text-align: center;
			margin-bottom: 50px;
		}
		
		.cart-header h1 {
			font-size: 36px;
			font-weight: 900;
			color: #0066CC;
			margin-bottom: 10px;
    		font-family: 'Montserrat', sans-serif;
		}
		
		.cart-header p {
			font-size: 16px;
			color: #666;
		}
		
		/* Table styles */
		.cart-table-wrapper {
			background: #fff;
			border-radius: 20px;
			box-shadow: 0 5px 20px rgba(0,0,0,0.05);
			overflow: hidden;
		}
		
		.cart-table {
			width: 100%;
			border-collapse: separate;
			border-spacing: 0;
		}
		
		.cart-table th {
			padding: 20px 15px;
			background: #f8f9fa;
			font-weight: 600;
			color: #495057;
			font-size: 14px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
			border-bottom: 2px solid #e9ecef;
		}
		
		.cart-table td {
			padding: 25px 15px;
			vertical-align: middle;
			border-bottom: 1px solid #f0f0f0;
		}
		
		.cart-table tr:last-child td {
			border-bottom: none;
		}
		
		/* Product image */
		.product-image {
			width: 100px;
			height: 100px;
			border-radius: 12px;
			overflow: hidden;
			background: #f8f9fa;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		
		.product-image img {
			width: 100%;
			height: 100%;
			object-fit: cover;
		}
		
		/* Product info */
		.product-name {
			font-weight: 600;
			font-size: 16px;
			color: #1a1a1a;
			margin-bottom: 8px;
			display: block;
		}
		
		.product-color {
			display: inline-flex;
			align-items: center;
			gap: 6px;
			font-size: 13px;
			color: #6c757d;
			padding: 4px 8px;
			background: #f8f9fa;
			border-radius: 20px;
		}
		
		.color-dot {
			width: 10px;
			height: 10px;
			border-radius: 50%;
			display: inline-block;
		}
		
		/* Quantity selector */
		.quantity-selector {
			display: inline-flex;
			align-items: center;
			border: 1px solid #e0e0e0;
			border-radius: 40px;
			overflow: hidden;
			background: #fff;
		}
		
		.qty-btn {
			width: 32px;
			height: 32px;
			display: flex;
			align-items: center;
			justify-content: center;
			background: #f8f9fa;
			border: none;
			cursor: pointer;
			transition: all 0.2s;
			color: #495057;
		}
		
		.qty-btn:hover {
			background: #e9ecef;
		}
		
		.qty-input {
			width: 50px;
			text-align: center;
			border: none;
			padding: 8px 0;
			font-weight: 500;
			font-size: 14px;
		}
		
		.qty-input:focus {
			outline: none;
		}
		
		/* Price */
		.price {
			font-weight: 600;
			font-size: 16px;
			color: #1a1a1a;
		}
		
		.total-price {
			font-weight: 700;
			font-size: 18px;
			color: #0066CC;
		}
		
		/* Remove button */
		.remove-btn {
			background: none;
			border: none;
			width: 32px;
			height: 32px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			cursor: pointer;
			color: #adb5bd;
			transition: all 0.2s;
		}
		
		.remove-btn:hover {
			background: #fee2e2;
			color: #e65540;
			transform: scale(1.05);
		}
		
		/* Cart actions */
		.cart-actions {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 20px 25px;
			background: #f8f9fa;
			border-top: 1px solid #e9ecef;
		}
		
		.action-link {
			display: inline-flex;
			align-items: center;
			gap: 8px;
			color: #495057;
			text-decoration: none;
			font-size: 14px;
			font-weight: 500;
			transition: all 0.2s;
		}
		
		.action-link:hover {
			color: #0066CC;
			transform: translateX(-3px);
		}
		
		.clear-cart {
			color: #dc3545;
		}
		
		.clear-cart:hover {
			color: #c82333;
			transform: none;
		}
		
		/* Order summary */
		.order-summary {
			background: #fff;
			border-radius: 20px;
			box-shadow: 0 5px 20px rgba(0,0,0,0.05);
			padding: 30px;
			position: sticky;
			top: 100px;
		}
		
		.order-summary h3 {
			font-size: 20px;
			font-weight: 700;
			color: #1a1a1a;
			margin-bottom: 25px;
			padding-bottom: 15px;
			border-bottom: 2px solid #f0f0f0;
		}
		
		.summary-row {
			display: flex;
			justify-content: space-between;
			padding: 12px 0;
			font-size: 15px;
		}
		
		.summary-row.total {
			border-top: 2px solid #f0f0f0;
			margin-top: 10px;
			padding-top: 20px;
			font-size: 18px;
			font-weight: 700;
		}
		
		.summary-label {
			color: #6c757d;
		}
		
		.summary-value {
			color: #1a1a1a;
			font-weight: 600;
		}
		
		.total .summary-label,
		.total .summary-value {
			color: #0066CC;
			font-size: 20px;
		}
		
		.free-shipping {
			color: #28a745;
			font-weight: 600;
			display: inline-flex;
			align-items: center;
			gap: 5px;
		}
		
		.checkout-btn {
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 10px;
			width: 100%;
			padding: 15px;
			background: linear-gradient(135deg, #0066CC, #0066CC);
			color: #fff;
			text-decoration: none;
			border-radius: 15px;
			font-weight: 600;
			margin-top: 20px;
			transition: all 0.3s;
		}
		
		.checkout-btn:hover {
			transform: translateY(-2px);
			box-shadow: 0 10px 25px rgba(113, 127, 224, 0.3);
			color: #fff;
		}
		
		/* Empty cart */
		.empty-cart {
			text-align: center;
			padding: 80px 20px;
			background: #fff;
			border-radius: 20px;
			box-shadow: 0 5px 20px rgba(0,0,0,0.05);
		}
		
		.empty-cart-icon {
			width: 120px;
			height: 120px;
			background: #f8f9fa;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0 auto 30px;
		}
		
		.empty-cart-icon i {
			font-size: 60px;
			color: #dee2e6;
		}
		
		.empty-cart h2 {
			font-size: 24px;
			color: #1a1a1a;
			margin-bottom: 15px;
		}
		
		.empty-cart p {
			color: #6c757d;
			margin-bottom: 30px;
		}
		
		.continue-shopping {
			display: inline-flex;
			align-items: center;
			gap: 10px;
			padding: 12px 30px;
			background: #0066CC;
			color: #fff;
			text-decoration: none;
			border-radius: 40px;
			font-weight: 500;
			transition: all 0.2s;
		}
		
		.continue-shopping:hover {
			background: #0066CC;
			transform: translateY(-2px);
			color: #fff;
		}
		
		/* Responsive */
		@media (max-width: 768px) {
			.cart-table-wrapper {
				overflow-x: auto;
			}
			
			.cart-table {
				min-width: 600px;
			}
			
			.order-summary {
				margin-top: 30px;
				position: static;
			}
			
			.cart-header h1 {
				font-size: 28px;
			}
		}
	</style>
</head>

<body class="animsition">
	<!-- Header -->
	@include('client.body.header')
	@include('frontend.modal')

	<div class="cart-container">
		<div class="cart-header">
			<h1>Mon Panier</h1>
			<p>Vérifiez vos articles et finalisez votre commande</p>
		</div>

		@if($cartItems->isEmpty())
			<div class="empty-cart">
				<div class="empty-cart-icon">
					<i class="zmdi zmdi-shopping-cart"></i>
				</div>
				<h2>Votre panier est vide</h2>
				<p>Découvrez nos produits et trouvez ce qui vous fera plaisir !</p>
				<a href="{{ route('client.product') }}" class="continue-shopping">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
						<path d="M19 12H5M12 19l-7-7 7-7"/>
					</svg>
					Continuer mes achats
				</a>
			</div>
		@else
		<div class="row">
			<div class="col-lg-8">
				<div class="cart-table-wrapper">
					<table class="cart-table">
						<thead>
							<tr>
								<th style="width: 40%">Produit</th>
								<th style="width: 20%">Prix unitaire</th>
								<th style="width: 20%">Quantité</th>
								<th style="width: 15%">Total</th>
								<th style="width: 5%"></th>
							</tr>
						</thead>
						<tbody>
							@foreach($cartItems as $item)
							<tr class="cart-row" data-item-id="{{ $item->id }}">
								<td>
									<div style="display: flex; align-items: center; gap: 15px;">
										<div class="product-image">
											@if($item->product->images->isNotEmpty())
												<img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
													alt="{{ $item->product->name }}">
											@else
												<img src="{{ asset('frontend/images/no-image.jpg') }}" alt="no image">
											@endif
										</div>
										<div>
											<span class="product-name">{{ $item->product->name }}</span>
											@if($item->color)
												<div class="product-color">
													<span class="color-dot" style="background: {{ $item->color->code }}"></span>
													{{ $item->color->name }}
												</div>
											@endif
										</div>
									</div>
								</td>
								<td>
									<span class="price">{{ number_format($item->product->price, 0, ',', ' ') }} FCFA</span>
								</td>
								<td>
									<div class="quantity-selector">
										<button type="button" class="qty-btn btn-qty-down" data-item-id="{{ $item->id }}">
											<i class="zmdi zmdi-minus"></i>
										</button>
										<input class="qty-input cart-qty-input"
											type="number"
											value="{{ $item->quantity }}"
											min="1"
											max="{{ $item->product->stock_quantity }}"
											data-item-id="{{ $item->id }}">
										<button type="button" class="qty-btn btn-qty-up" data-item-id="{{ $item->id }}">
											<i class="zmdi zmdi-plus"></i>
										</button>
									</div>
								</td>
								<td>
									<span class="total-price cart-line-total" data-item-id="{{ $item->id }}">
										{{ number_format($item->product->price * $item->quantity, 0, ',', ' ') }} FCFA
									</span>
								</td>
								<td>
									<button type="button" class="remove-btn btn-remove-cart" data-item-id="{{ $item->id }}">
										<i class="zmdi zmdi-close"></i>
									</button>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					
					<div class="cart-actions">
						<a href="{{ route('client.product') }}" class="action-link">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M19 12H5M12 19l-7-7 7-7"/>
							</svg>
							Continuer mes achats
						</a>
						<button id="btn-clear-cart" class="action-link clear-cart">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
								<path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
							</svg>
							Vider le panier
						</button>
					</div>
				</div>
			</div>

			<div class="col-lg-4">
				<div class="order-summary">
					<h3>Récapitulatif</h3>
					
					<div class="summary-row">
						<span class="summary-label">Sous-total</span>
						<span class="summary-value" id="cart-subtotal">
							{{ number_format($subtotal, 0, ',', ' ') }} FCFA
						</span>
					</div>
					
					<div class="summary-row">
						<span class="summary-label">Livraison</span>
						<span class="summary-value">
							@if($subtotal >= 1000000)
								<span class="free-shipping">
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
										<path d="M20 12H4M12 4v16"/>
									</svg>
									Gratuite
								</span>
							@else
								À calculer à la commande
							@endif
						</span>
					</div>
					
					<div class="summary-row total">
						<span class="summary-label">Total TTC</span>
						<span class="summary-value" id="cart-total">
							{{ number_format($subtotal, 0, ',', ' ') }} FCFA
						</span>
					</div>
					
					<a href="{{ route('client.checkout') }}" class="checkout-btn">
						Passer la commande
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
							<path d="M5 12h14M12 5l7 7-7 7"/>
						</svg>
					</a>
					
					<div style="margin-top: 20px; text-align: center; font-size: 12px; color: #adb5bd;">
						<i class="zmdi zmdi-lock"></i> Paiement sécurisé
					</div>
				</div>
			</div>
		</div>
		@endif
	</div>

	@include('client.body.footer')

	<!-- Scripts -->
	<script src="{{ asset('frontend/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/select2/select2.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('frontend/vendor/slick/slick.min.js') }}"></script>
	<script src="{{ asset('frontend/js/slick-custom.js') }}"></script>
	<script src="{{ asset('frontend/vendor/parallax100/parallax100.js') }}"></script>
	<script src="{{ asset('frontend/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/isotope/isotope.pkgd.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/sweetalert/sweetalert.min.js') }}"></script>
	<script src="{{ asset('frontend/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
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
					
					// Mise à jour du message de livraison
					if (res.subtotal_raw >= 1000000) {
						$('.summary-row:eq(1) .summary-value').html('<span class="free-shipping"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12H4M12 4v16"/></svg> Gratuite</span>');
					} else {
						$('.summary-row:eq(1) .summary-value').text('À calculer à la commande');
					}
				},
				error: function () {
					swal('Erreur', 'Impossible de mettre à jour la quantité.', 'error');
				}
			});
		}

		/* ── Supprimer un article ───────────────────────────── */
		$(document).on('click', '.btn-remove-cart', function () {
			const itemId = $(this).data('item-id');
			const $row = $(this).closest('.cart-row');

			swal({
				title: 'Supprimer l\'article ?',
				text: 'Cet article sera retiré de votre panier.',
				icon: 'warning',
				buttons: ['Annuler', 'Supprimer'],
				dangerMode: true,
			}).then(function (confirmed) {
				if (!confirmed) return;
				
				$.ajax({
					url: '{{ route("client.cart.remove") }}',
					method: 'POST',
					data: { item_id: itemId, _token: TOKEN },
					success: function (res) {
						$row.fadeOut(300, function () {
							$(this).remove();
							if ($('.cart-row').length === 0) {
								location.reload();
							}
						});
						$('#cart-subtotal, #cart-total').text(res.subtotal + ' FCFA');
						updateHeaderCount(res.cart_count);
						
						swal('Supprimé !', 'L\'article a été retiré de votre panier.', 'success');
					},
					error: function () {
						swal('Erreur', 'Impossible de supprimer cet article.', 'error');
					}
				});
			});
		});

		/* ── Vider le panier ────────────────────────────────── */
		$('#btn-clear-cart').on('click', function () {
			swal({
				title: 'Vider le panier ?',
				text: 'Tous les articles seront supprimés définitivement.',
				icon: 'warning',
				buttons: ['Annuler', 'Vider le panier'],
				dangerMode: true,
			}).then(function (confirmed) {
				if (!confirmed) return;
				$.ajax({
					url: '{{ route("client.cart.clear") }}',
					method: 'POST',
					data: { _token: TOKEN },
					success: function () { 
						location.reload(); 
					},
					error: function () { 
						swal('Erreur', 'Impossible de vider le panier.', 'error'); 
					}
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