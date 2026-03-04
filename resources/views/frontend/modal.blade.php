
	<!-- Cart Sidebar -->
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-25 p-r-20">

			{{-- Titre --}}
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">Mon Panier</span>
				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>

			{{-- Contenu scrollable --}}
			<div class="header-cart-content flex-w js-pscroll">

				{{-- Liste des articles --}}
				<ul class="header-cart-wrapitem w-full" id="sidebar-cart-items">
					{{-- Rempli dynamiquement par JS --}}
					<li class="header-cart-empty txt-center p-t-30 p-b-10" style="display:none">
						<i class="zmdi zmdi-shopping-cart" style="font-size:40px;color:#ddd"></i>
						<p class="stext-107 cl6 p-t-10">Votre panier est vide.</p>
					</li>
				</ul>

				{{-- Pied : total + boutons --}}
				<div class="w-full" id="sidebar-cart-footer">
					<div class="header-cart-total w-full p-tb-40 me-3">
						Total : <span id="sidebar-cart-total">0 FCFA</span>
					</div>

					<div class="header-cart-buttons flex-w w-full justify-content-center">
						<a href="{{ route('client.cart') }}"
						class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10" style="width: 80% !important">
							Voir le panier
						</a>
						{{-- <a href="{{ route('client.checkout') }}"
						class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
							Commander
						</a> --}}
					</div>
				</div>

			</div>
		</div>
	</div>


	{{-- ================================================================
	STYLES spécifiques au sidebar panier
	================================================================ --}}
	<style>
		/* Article dans le sidebar */
		.header-cart-item-img img {
			width: 70px;
			height: 70px;
			object-fit: cover;
			border-radius: 4px;
		}

		/* Bouton supprimer dans le sidebar */
		.sidebar-cart-remove {
			background: none;
			border: none;
			color: #aaa;
			font-size: 14px;
			cursor: pointer;
			padding: 0 4px;
			transition: color .2s;
			margin-left: auto;
			flex-shrink: 0;
		}
		.sidebar-cart-remove:hover { color: #e65540; }

		/* Ligne couleur */
		.sidebar-color-dot {
			display: inline-block;
			width: 10px; height: 10px;
			border-radius: 50%;
			border: 1px solid rgba(0,0,0,.15);
			margin-right: 4px;
			vertical-align: middle;
		}

		/* Loader */
		.sidebar-cart-loader {
			text-align: center;
			padding: 30px 0;
			color: #aaa;
			font-size: 13px;
		}
		.sidebar-cart-loader i { font-size: 24px; display: block; margin-bottom: 8px; }
	</style>