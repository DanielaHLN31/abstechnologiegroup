
	{{-- ================================================================
     MODAL QUICK VIEW — remplace le wrap-modal1 existant
     ================================================================ --}}
	<div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
		<div class="overlay-modal1 js-hide-modal1"></div>

		<div class="container">
			<div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
				<button class="how-pos3 hov3 trans-04 js-hide-modal1">
					<img src="{{ asset('frontend/images/icons/icon-close.png') }}" alt="CLOSE">
				</button>

				{{-- Loader --}}
				<div id="modal1-loader" class="txt-center p-t-30 p-b-30" style="display:none">
					<div class="modal1-spinner"></div>
					<p class="stext-107 cl6 p-t-15">Chargement...</p>
				</div>

				{{-- Contenu --}}
				<div id="modal1-content" class="row" style="display:none">

					{{-- Galerie --}}
					{{-- Galerie --}}
					<div class="col-md-6 col-lg-7 p-b-30">
						<div class="p-l-25 p-r-30 p-lr-0-lg">
							<div class="wrap-slick3 flex-sb flex-w">
								{{-- Thumbnails verticaux à gauche --}}
								<div class="wrap-slick3-dots" id="modal1-thumbs"></div>
								
								{{-- Flèches + image principale --}}
								<div class="wrap-slick3-arrows flex-sb-m flex-w" style="position:relative; flex:1;">
									<div id="modal1-slick-arrows" class="flex-sb-m w-full" style="position:absolute;top:50%;transform:translateY(-50%);z-index:10;pointer-events:none;">
										{{-- <button class="arrow-slick3 prev-slick3-modal" style="pointer-events:all"><i class="fa fa-angle-left"></i></button>
										<button class="arrow-slick3 next-slick3-modal" style="pointer-events:all"><i class="fa fa-angle-right"></i></button> --}}
									</div>
									<div class="slick3 gallery-lb" id="modal1-slick"></div>
								</div>
							</div>
						</div>
					</div>

					{{-- Infos produit --}}
					<div class="col-md-6 col-lg-5 p-b-30">
						<div class="p-r-50 p-t-5 p-lr-0-lg">

							{{-- Badges statut / vedette --}}
							<div id="modal1-badges" class="p-b-10"></div>

							{{-- Nom --}}
							<h4 class="mtext-105 cl2 js-name-detail p-b-14" id="modal1-name"></h4>

							{{-- Prix --}}
							<div id="modal1-price" class="p-b-12"></div>

							{{-- Catégorie & Marque --}}
							<div id="modal1-meta" class="p-b-14 modal1-meta-row"></div>

							{{-- Description --}}
							<p class="stext-102 cl3 p-t-10 p-b-10" id="modal1-desc"></p>

							{{-- Couleurs --}}
							<div id="modal1-colors-wrap" class="p-t-10 p-b-10" style="display:none">
								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">Couleur</div>
									<div class="size-204 respon6-next">
										<div class="modal1-colors-list" id="modal1-colors-list"></div>
									</div>
								</div>
							</div>

							{{-- Spécifications --}}
							<div id="modal1-specs-wrap" class="p-b-10" style="display:none">
								<div class="modal1-specs-title p-b-6">Spécifications</div>
								<div id="modal1-specs-list"></div>
							</div>

							{{-- Stock --}}
							<div id="modal1-stock" class="p-b-14"></div>

							{{-- Quantité + Panier --}}
							<div class="p-t-20">
								<div class="flex-w flex-r-m p-b-10">
									<div class="size-204 flex-w flex-m respon6-next">
										<div class="wrap-num-product flex-w m-r-20 m-tb-10">
											<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" id="modal1-qty-down">
												<i class="fs-16 zmdi zmdi-minus"></i>
											</div>
											<input class="mtext-104 cl3 txt-center num-product"
												type="number" id="modal1-qty" value="1" min="1">
											<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" id="modal1-qty-up">
												<i class="fs-16 zmdi zmdi-plus"></i>
											</div>
										</div>
										<button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04"
												id="modal1-add-cart">
											Ajouter au panier
										</button>
									</div>
								</div>
							</div>

							{{-- Lien détail complet --}}
							{{-- <div class="flex-w flex-m p-t-20">
								<a id="modal1-detail-link" href="#"
								class="stext-107 cl6 hov-cl1 trans-04 p-r-20">
									<i class="zmdi zmdi-eye m-r-5"></i> Voir la fiche complète
								</a>
								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
								data-tooltip="Ajouter aux favoris">
									<i class="zmdi zmdi-favorite-outline"></i>
								</a>
							</div> --}}

						</div>
					</div>

				</div>{{-- /modal1-content --}}
			</div>
		</div>
	</div>