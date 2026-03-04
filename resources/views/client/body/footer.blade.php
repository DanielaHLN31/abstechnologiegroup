
	<!-- Footer -->
	<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<!-- Catégories dynamiques -->
				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Catégories
					</h4>

					<ul>
						@if(isset($categories) && $categories->count() > 0)
							@foreach($categories->take(4) as $category)
								<li class="p-b-10">
									<a href="{{ route('client.product', ['category' => $category->id]) }}" 
									class="stext-107 cl7 hov-cl1 trans-04">
										{{ $category->name }}
									</a>
								</li>
							@endforeach
						@else
							<li class="p-b-10">
								<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
									Women
								</a>
							</li>
							<li class="p-b-10">
								<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
									Men
								</a>
							</li>
							<li class="p-b-10">
								<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
									Shoes
								</a>
							</li>
							<li class="p-b-10">
								<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
									Watches
								</a>
							</li>
						@endif
					</ul>
				</div>

				<!-- Aide et support -->
				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Aide
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="{{ route('client.my.orders') }}" class="stext-107 cl7 hov-cl1 trans-04">
								Suivre ma commande
							</a>
						</li>
						<li class="p-b-10">
							<a href="{{route('client.about')}}" class="stext-107 cl7 hov-cl1 trans-04">
								A propos
							</a>
						</li>
						<li class="p-b-10">
							<a href="{{route('client.contact')}}" class="stext-107 cl7 hov-cl1 trans-04">
								Livraison
							</a>
						</li>
						<li class="p-b-10">
							<a href="{{route('client.faqs')}}" class="stext-107 cl7 hov-cl1 trans-04">
								FAQs
							</a>
						</li>
					</ul>
				</div>

				<!-- Contact -->
				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						NOUS CONTACTER
					</h4>

					<p class="stext-107 cl7 size-201">
						<i class="fa fa-map-marker m-r-5"></i> CAMP-GUEZO, Face Hôpital des Armées (HIA),Cotonou, Bénin<br>
						<i class="fa fa-phone m-r-5"></i> (+229) 01 96 06 06 26<br>
						<i class="fa fa-envelope m-r-5"></i> dc@abstechnologie.com
					</p>

					<div class="p-t-27">
						<a href="https://facebook.com/abstechnologiegroup" target="_blank" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-facebook"></i>
						</a>
						<a href="https://wa.me/2290196062626" target="_blank" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-whatsapp"></i>
						</a>
					</div>
				</div>

				<!-- Newsletter -->
				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Newsletter
					</h4>

					<p class="stext-107 cl7 size-201 p-b-10">
						Inscrivez-vous pour recevoir nos offres spéciales
					</p>

					<form action="" method="POST">
						@csrf
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" 
								type="email" 
								name="email" 
								placeholder="email@exemple.com" 
								required>
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button type="submit" 
									class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								S'abonner
							</button>
						</div>
					</form>
				</div>
			</div>

			<!-- Paiements et copyright -->
			<div class="p-t-40">
				<div class="flex-c-m flex-w p-b-18">
					<a href="#" class="m-all-1">
						<img src="{{ asset('frontend/images/icons/icon-pay-01.png') }}" alt="Visa">
					</a>
					<a href="#" class="m-all-1">
						<img src="{{ asset('frontend/images/icons/icon-pay-02.png') }}" alt="Mastercard">
					</a>
					<a href="#" class="m-all-1">
						<img src="{{ asset('frontend/images/icons/icon-pay-03.png') }}" alt="Amex">
					</a>
					<a href="#" class="m-all-1">
						<img src="{{ asset('frontend/images/icons/icon-pay-04.png') }}" alt="Paypal">
					</a>
					<a href="#" class="m-all-1">
						<img src="{{ asset('frontend/images/icons/icon-pay-05.png') }}" alt="Apple Pay">
					</a>
				</div>

				<div class="row">
					<div class="col-md-6">
						<p class="stext-107 cl6 txt-left">
							Copyright &copy;<script>document.write(new Date().getFullYear());</script> 
							<a href="{{ route('client.index') }}" class="hov-cl1">ABS TECHNOLOGIE</a>. 
							Tous droits réservés.
						</p>
					</div>
					<div class="col-md-6">
						<p class="stext-107 cl6 txt-right">
							Réalisé par <a href="https://abstechnologie.com" target="_blank" class="hov-cl1">ABS Technologie Group</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</footer>


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

	{{--
    ================================================================
    SCRIPT GLOBAL — À placer dans ton layout principal (layouts/frontend.blade.php)
    AVANT </body>, après l'inclusion de jQuery et sweetalert.

    Gère :
    - Boutons wishlist (icônes cœur) partout sur le site
    - Redirection vers login si non connecté (panier + wishlist)
    - Badge wishlist dans le header
    - Suggestions de recherche en temps réel (autocomplete)
    ================================================================
--}}
