
	<!-- Header -->

	<header>
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						Livraison gratuite pour toute commande de plus de 500 000 FCFA
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

							<li class="menu-item-has-children {{ request()->routeIs('client.product') ? 'active-menu' : '' }}">
								<a href="{{ route('client.product') }}">
									<span >Boutique</span>
									<svg width="12" height="12" viewBox="0 0 24 24" fill="none" 
										stroke="currentColor" stroke-width="2.5" 
										style="margin-left:4px;transition:transform .2s">
										<path d="M6 9l6 6 6-6"/>
									</svg>
								</a>

								<ul class="sub-menu">
									<li>
										<a href="{{ route('client.product') }}">
											<span class="sub-menu-dot"></span>
											Tous les produits
										</a>
									</li>
									@foreach($headerCategories as $cat)
									<li>
										<a href="{{ route('client.product', ['category' => $cat->id]) }}">
											<span class="sub-menu-dot"></span>
											{{ $cat->name }}
											{{-- <span class="sub-menu-count">{{ $cat->products_count }}</span> --}}
										</a>
									</li>
									@endforeach
								</ul>
							</li>

							{{-- <li class=" {{ request()->routeIs('client.new') ? 'active-menu' : '' }}">
								<a href="{{ route('client.new') }}">Nouveautés</a>
							</li> --}}

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
					<img src="{{ asset('frontend/images/icons/logo.png') }}" alt="Logo">
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
						Livraison gratuite pour toute commande de plus de 500 000 FCFA
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
				<li class="menu-item-has-children-mobile">
					<div class="mobile-menu-toggle" onclick="toggleMobileSubmenu(this)">
						<a href="{{ route('client.product') }}"><span style="margin-left: 21px; font-weight:500; color:#fff">Boutique</span></a>
						<button type="button" class="mobile-submenu-arrow">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" 
								stroke="currentColor" stroke-width="2.5">
								<path d="M6 9l6 6 6-6"/>
							</svg>
						</button>
					</div>
					<ul class="sub-menu-mobile">
						<li>
							<a href="{{ route('client.product') }}">Tous les produits</a>
						</li>
						{{-- @foreach(\App\Models\Category::where('status', 1)->get() as $cat)
						<li>
							<a href="{{ route('client.product', ['category' => $cat->id]) }}">
								{{ $cat->name }}
							</a>
						</li>
						@endforeach --}}
						@foreach($headerCategories as $cat)
						<li>
							<a href="{{ route('client.product', ['category' => $cat->id]) }}" style=" color:#fff">
								<span class="sub-menu-dot"></span>
								{{ $cat->name }}
								{{-- <span class="sub-menu-count">{{ $cat->products_count }}</span> --}}
							</a>
						</li>
						@endforeach
					</ul>
				</li>
				{{-- <li>
					<a href="{{ route('client.new') }}" class="rs1">Nouveautés</a>
				</li> --}}
				<li>
					<a href="{{ route('client.about') }}">À propos</a>
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

	<style>
		/* ══════════════════════════════════════════
		SOUS-MENU DESKTOP
		══════════════════════════════════════════ */
		.menu-item-has-children {
			position: relative;
		}

		.menu-item-has-children > a {
			display: flex;
			align-items: center;
		}

		/* Flèche rotation au hover */
		.menu-item-has-children:hover > a svg {
			transform: rotate(180deg);
		}

		.sub-menu {
			position: absolute;
			top: calc(100% + 8px);
			left: 50%;
			transform: translateX(-50%);
			min-width: 240px;
			background: #fff;
			/* border-radius: 14px; */
			box-shadow: 0 8px 32px rgba(10,22,40,.14);
			border: 1px solid #e8eef8;
			padding: 8px 0;
			list-style: none;
			margin: 0;
			z-index: 9999;

			/* Animation */
			opacity: 0;
			visibility: hidden;
			transform: translateX(-50%) translateY(8px);
			transition: opacity .25s ease, transform .25s ease, visibility .25s;
			pointer-events: none;
		}

		/* Petite flèche vers le haut */
		.sub-menu::before {
			content: '';
			position: absolute;
			top: -6px;
			left: 50%;
			transform: translateX(-50%);
			width: 12px;
			height: 12px;
			background: #fff;
			border-left: 1px solid #e8eef8;
			border-top: 1px solid #e8eef8;
			rotate: 45deg;
		}

		.menu-item-has-children:hover .sub-menu {
			opacity: 1;
			visibility: visible;
			transform: translateX(-50%) translateY(0);
			pointer-events: auto;
		}

		.sub-menu li a {
			display: flex;
			align-items: center;
			justify-content: space-between;
			padding: 10px 20px;
			font-size: 14px;
			color: #0a1628 !important;
			text-decoration: none;
			transition: all .2s;
			gap: 10px;
			justify-content: flex-start;
		}

		.sub-menu li a:hover {
			background: #f4f7fd;
			color: #0066CC !important;
			padding-left: 26px;
		}

		.sub-menu li:first-child a {
			font-weight: 700;
			color: #0066CC !important;
			border-bottom: 1px solid #e8eef8;
			margin-bottom: 4px;
		}

		.sub-menu-dot {
			width: 6px;
			height: 6px;
			border-radius: 50%;
			background: #c8d4e8;
			flex-shrink: 0;
			transition: background .2s;
		}
		.sub-menu li a:hover .sub-menu-dot {
			background: #0066CC;
		}

		.sub-menu-count {
			margin-left: auto;
			font-size: 11px;
			font-weight: 600;
			background: #f0f4ff;
			color: #0066CC;
			padding: 2px 8px;
			border-radius: 20px;
			flex-shrink: 0;
		}

		/* ══════════════════════════════════════════
		SOUS-MENU MOBILE
		══════════════════════════════════════════ */
		.menu-item-has-children-mobile {
			list-style: none;
		}

		.mobile-menu-toggle {
			display: flex;
			align-items: center;
			justify-content: space-between;
		}

		.mobile-menu-toggle a {
			flex: 1;
		}

		.mobile-submenu-arrow {
			background: none;
			border: none;
			cursor: pointer;
			padding: 8px 12px;
			color: inherit;
			transition: transform .25s;
			display: flex;
			align-items: center;
		}

		.mobile-submenu-arrow.open {
			transform: rotate(180deg);
		}

		.sub-menu-mobile {
			list-style: none;
			margin: 0;
			padding: 0 0 0 16px;
			max-height: 0;
			overflow: hidden;
			transition: max-height .35s ease;
		}

		.sub-menu-mobile.open {
			max-height: 600px;
		}

		.sub-menu-mobile li a {
			display: block;
			padding: 10px 12px;
			font-size: 14px;
			color: #6b7a99;
			text-decoration: none;
			border-left: 2px solid #e8eef8;
			transition: all .2s;
		}

		.sub-menu-mobile li a:hover,
		.sub-menu-mobile li:first-child a {
			color: #0066CC;
			border-left-color: #0066CC;
		}
	</style>

	<script>
		function toggleMobileSubmenu(el) {
			var arrow  = el.querySelector('.mobile-submenu-arrow');
			var submenu = el.closest('li').querySelector('.sub-menu-mobile');

			arrow.classList.toggle('open');
			submenu.classList.toggle('open');
		}
	</script>