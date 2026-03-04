
	<!-- Header -->

	<header>
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						Livraison gratuite pour toute commande de plus de 1 000 000 FCFA
					</div>

					<div class="right-top-bar flex-w h-full">
						<a href="{{ route('client.faqs') }}" class="flex-c-m trans-04 p-lr-25">
							Aide & FAQs
						</a>

						@auth
							<a href="{{ route('client.account') }}" class="flex-c-m trans-04 p-lr-25">
								Mon Compte
							</a>
							<a href="{{ route('auth.logout') }}" class="flex-c-m trans-04 p-lr-25" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								Déconnexion
							</a>
							<form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						@else
							<a href="{{ route('client.login') }}" class="flex-c-m trans-04 p-lr-25">
								Connexion
							</a>
							<a href="{{ route('client.register') }}" class="flex-c-m trans-04 p-lr-25">
								Inscription
							</a>
						@endauth

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							FR
						</a>

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							FCFA
						</a>
					</div>
				</div>
			</div>

			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">
					
					<!-- Logo desktop -->		
					<a href="{{ route('client.index') }}" class="logo">
						<div class="d-flex">
							<img src="{{ asset('frontend/images/icons/logo.png') }}" alt="Logo">
							
						</div>
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="{{ request()->routeIs('client.index') ? 'active-menu' : '' }}">
								<a href="{{ route('client.index') }}">Accueil</a>
							</li>

							<li class="{{ request()->routeIs('client.product') ? 'active-menu' : '' }}">
								<a href="{{ route('client.product') }}">Boutique</a>
							</li>

							<li class=" {{ request()->routeIs('client.new') ? 'active-menu' : '' }}">
								<a href="{{ route('client.new') }}">Nouveautés</a>
							</li>

							<li class="{{ request()->routeIs('client.about') ? 'active-menu' : '' }}">
								<a href="{{ route('client.about') }}">À propos</a>
							</li>

							<li class="{{ request()->routeIs('client.contact') ? 'active-menu' : '' }}">
								<a href="{{ route('client.contact') }}">Contact</a>
							</li>
						</ul>
					</div>	

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>

						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
							data-notify="{{ auth()->check()
								? \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity')
								: \App\Models\CartItem::where('session_id', session()->getId())->sum('quantity')
							}}">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>

						<a href="{{ route('client.wishlist') }}" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" 
						data-notify="0">
							<i class="zmdi zmdi-favorite-outline"></i>
						</a>
					</div>
				</nav>
			</div>	
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo mobile -->		
			<div class="logo-mobile">
				<a href="{{ route('client.index') }}">
					<img src="{{ asset('frontend/images/icons/logo-01.png') }}" alt="Logo">
				</a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>

				<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
					data-notify="{{ auth()->check()
						? \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity')
						: \App\Models\CartItem::where('session_id', session()->getId())->sum('quantity')
					}}">
					<i class="zmdi zmdi-shopping-cart"></i>
				</div>

				<a href="{{ route('client.wishlist') }}" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" 
				data-notify="">
					<i class="zmdi zmdi-favorite-outline"></i>
				</a>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>

		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile">
				<li>
					<div class="left-top-bar">
						Livraison gratuite pour toute commande de plus de 1 000 000 FCFA
					</div>
				</li>

				<li>
					<div class="right-top-bar flex-w h-full">
						<a href="{{ route('client.faqs') }}" class="flex-c-m p-lr-10 trans-04">
							Aide & FAQs
						</a>

						@auth
							<a href="{{ route('client.account') }}" class="flex-c-m p-lr-10 trans-04">
								Mon Compte
							</a>
							<a href="{{ route('auth.logout') }}" class="flex-c-m p-lr-10 trans-04" 
							onclick="event.preventDefault(); document.getElementById('mobile-logout-form').submit();">
								Déconnexion
							</a>
							<form id="mobile-logout-form" action="{{ route('auth.logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						@else
							<a href="{{ route('client.login') }}" class="flex-c-m p-lr-10 trans-04">
								Connexion
							</a>
							<a href="{{ route('client.register') }}" class="flex-c-m p-lr-10 trans-04">
								Inscription
							</a>
						@endauth

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							FR
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							FCFA
						</a>
					</div>
				</li>
			</ul>

			<ul class="main-menu-m">
				<li>
					<a href="{{ route('client.index') }}">Accueil</a>
				</li>
				<li>
					<a href="{{ route('client.product') }}">Boutique</a>
				</li>
				<li>
					<a href="{{ route('client.new') }}" class="rs1">Nouveautés</a>
				</li>
				<li>
					{{-- <a href="{{ route('client.about') }}">À propos</a> --}}
				</li>
				<li>
					<a href="{{ route('client.contact') }}">Contact</a>
				</li>
			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="{{ asset('frontend/images/icons/icon-close2.png') }}" alt="Fermer">
				</button>

				<form class="wrap-search-header flex-w p-l-15" action="{{ route('client.search') }}" method="GET">
					<button type="submit" class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="q" placeholder="Rechercher un produit..." required>
				</form>
			</div>
		</div>
	</header>
