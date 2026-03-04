


				<div class="flex-w flex-c-m m-tb-10">
					<div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
						<i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
						<i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						Filtrer
					</div>

					<div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
						<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
						<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						Rechercher
					</div>
				</div>
				
				<!-- Search product -->
				<div class="dis-none panel-search w-full p-t-10 p-b-15">
					<div class="bor8 dis-flex p-l-15">
						<button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
							<i class="zmdi zmdi-search"></i>
						</button>
						<input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" id="search-product" placeholder="Rechercher un produit...">
					</div>
				</div>

				<!-- Filter -->
				<div class="dis-none panel-filter w-full p-t-10">
					<div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">

						<div class="filter-col1 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Couleur
							</div>
							<div class="flex-w p-t-4 m-r--5">
								<a href="#" class="filter-color-link flex-c-m trans-04 m-r-8 m-b-8 filter-link-active" data-color="all"
									style="width:28px; height:28px; border-radius:50%; background:#fff; border:2px solid #aaa;" 
									title="Toutes">
									<i class="zmdi zmdi-check fs-12" style="color:#aaa;"></i>
								</a>
								@foreach($colors as $color)
								<a href="#" class="filter-color-link trans-04 m-r-8 m-b-8" data-color="{{ $color->id }}"
									style="width:28px; height:28px; border-radius:50%; background:{{ $color->code }}; border:2px solid transparent; display:inline-block;"
									title="{{ $color->name }}">
								</a>
								@endforeach
							</div>
						</div>

						<div class="filter-col2 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Prix
							</div>
							<ul>
								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04 filter-link-active" data-price="all">Tous</a>
								</li>
								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04" data-price="0-50000">0 – 50 000 FCFA</a>
								</li>
								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04" data-price="50000-100000">50 000 – 100 000 FCFA</a>
								</li>
								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04" data-price="100000-250000">100 000 – 250 000 FCFA</a>
								</li>
								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04" data-price="250000-500000">250 000 – 500 000 FCFA</a>
								</li>
								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04" data-price="500000+">500 000 FCFA et plus</a>
								</li>
							</ul>
						</div>

						<div class="filter-col3 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Catégories
							</div>
							<ul>
								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04 filter-link-active" data-category="all">Toutes</a>
								</li>
								@foreach($categories as $category)
								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04" data-category="{{ $category->id }}">
										{{ $category->name }}
									</a>
								</li>
								@endforeach
							</ul>
						</div>

						<div class="filter-col4 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Marques
							</div>
							<div class="flex-w p-t-4 m-r--5">
								<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5" data-brand="all">
									Toutes
								</a>
								@foreach($brands as $brand)
								<a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5" data-brand="{{ $brand->id }}">
									{{ $brand->name }}
								</a>
								@endforeach
							</div>
						</div>

					</div>
				</div>
			</div>

