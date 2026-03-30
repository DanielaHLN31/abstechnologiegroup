<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Mes favoris | ABS-TECHNOLOGIE</title>
    @include('client.body.head')
    
    <style>
        /* ===== STYLES MODERNES POUR LA WISHLIST ===== */
        .wishlist-hero {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 3rem 0;
            margin-bottom: 2rem;
            border-radius: 0 0 2rem 2rem;
        }
        
        .wishlist-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #1A2C3E, #0066CC);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
        }
        
        .wishlist-count {
            font-size: 1rem;
            color: #64748b;
            margin-left: 0.75rem;
            font-weight: 500;
        }
        
        /* Grille produits moderne */
        #wishlist-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
        }
        
        .wishlist-card {
            flex: 0 0 calc(25% - 1.125rem);
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.5s ease forwards;
            opacity: 0;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Carte produit modernisée */
        .modern-product-card {
            background: white;
            border-radius: 1.25rem;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #eef2f6;
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        
        .modern-product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 35px rgba(0, 102, 204, 0.12);
            border-color: rgba(0, 102, 204, 0.2);
        }
        
        /* Zone image */
        .product-image-wrapper {
            position: relative;
            background: #f8fafc;
            padding: 1.5rem;
            text-align: center;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .product-image-wrapper img {
            max-height: 160px;
            max-width: 100%;
            object-fit: contain;
            transition: transform 0.4s ease;
        }
        
        .modern-product-card:hover .product-image-wrapper img {
            transform: scale(1.05);
        }
        
        /* Badges */
        .product-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #e65540;
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.25rem 0.7rem;
            border-radius: 20px;
            z-index: 2;
        }
        
        .product-badge.sale {
            background: #e65540;
        }
        
        .product-badge.stock {
            background: #f0ad4e;
        }
        
        /* Bouton remove wishlist */
        .btn-remove-wishlist {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            font-size: 1.1rem;
            color: #e65540;
            transition: all 0.2s ease;
            z-index: 10;
        }
        
        .btn-remove-wishlist:hover {
            transform: scale(1.1);
            background: #e65540;
            color: white;
        }
        
        /* Infos produit */
        .product-info {
            padding: 1.2rem 1rem 1rem;
            flex: 1;
        }
        
        .product-category {
            font-size: 0.7rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
            display: inline-block;
        }
        
        .product-name {
            font-weight: 700;
            font-size: 1rem;
            color: #1e293b;
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .product-price {
            display: flex;
            align-items: baseline;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 0.5rem;
        }
        
        .current-price {
            font-size: 1.2rem;
            font-weight: 800;
            color: #0066CC;
        }
        
        .old-price {
            font-size: 0.85rem;
            color: #94a3b8;
            text-decoration: line-through;
        }
        
        /* Couleurs */
        .product-colors {
            display: flex;
            gap: 0.4rem;
            margin-top: 0.5rem;
            flex-wrap: wrap;
        }
        
        .color-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .color-dot:hover {
            transform: scale(1.15);
        }
        
        /* Stock */
        .stock-status {
            font-size: 0.7rem;
            margin-top: 0.5rem;
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
        }
        
        .stock-in {
            background: #dcfce7;
            color: #15803d;
        }
        
        .stock-low {
            background: #fef9c3;
            color: #854d0e;
        }
        
        .stock-out {
            background: #fee2e2;
            color: #b91c1c;
        }
        
        /* Bouton panier */
        .cart-action {
            padding: 0.8rem 1rem 1rem;
            border-top: 1px solid #eef2f6;
            background: white;
        }
        
        .btn-add-cart {
            width: 100%;
            background: linear-gradient(135deg, #0066CC, #0052a3);
            border: none;
            border-radius: 0.75rem;
            padding: 0.7rem;
            font-weight: 600;
            font-size: 0.85rem;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-add-cart:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0, 102, 204, 0.25);
        }
        
        .btn-add-cart:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
            transform: none;
        }
        
        /* Actions globales */
        .wishlist-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2rem 0;
            padding: 1rem 0;
            border-top: 1px solid #eef2f6;
            border-bottom: 1px solid #eef2f6;
        }
        
        .btn-continue {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #0066CC;
            text-decoration: none;
            font-weight: 500;
            transition: gap 0.2s;
        }
        
        .btn-continue:hover {
            gap: 0.75rem;
            color: #0052a3;
        }
        
        .btn-clear-all {
            background: transparent;
            border: 1px solid #e2e8f0;
            padding: 0.6rem 1.2rem;
            border-radius: 2rem;
            font-weight: 500;
            color: #e65540;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-clear-all:hover {
            background: #e65540;
            border-color: #e65540;
            color: white;
        }
        
        /* État vide */
        .empty-wishlist {
            text-align: center;
            padding: 4rem 2rem;
            background: #f8fafc;
            border-radius: 2rem;
            margin: 2rem 0;
        }
        
        .empty-icon {
            font-size: 5rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }
        
        /* Animation de suppression */
        .card-removing {
            animation: fadeOut 0.3s ease forwards;
        }
        
        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: scale(0.95);
            }
        }
        
        @media (max-width: 992px) {
            .wishlist-card {
                flex: 0 0 calc(33.333% - 1rem);
            }
        }
        
        @media (max-width: 768px) {
            .wishlist-card {
                flex: 0 0 calc(50% - 0.75rem);
            }
        }
        
        @media (max-width: 576px) {
            .wishlist-card {
                flex: 0 0 100%;
            }
            .wishlist-actions {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>

<body class="animsition">
    @include('client.body.header')
    @include('frontend.modal')

    <!-- Hero Section Wishlist -->
    <div class="wishlist-hero mt-5">
        <div class="container">
            <div class="text-center">
                <h1 class="wishlist-title">
                    <i class="zmdi zmdi-favorite-outline" style="color: #e65540; margin-right: 0.5rem;"></i>
                    Mes Favoris
                    @if($wishlistItems->isNotEmpty())
                        <span class="wishlist-count">({{ $wishlistItems->count() }} article{{ $wishlistItems->count() > 1 ? 's' : '' }})</span>
                    @endif
                </h1>
                <p class="text-muted mt-2">Retrouvez ici tous les produits que vous avez aimés</p>
            </div>
        </div>
    </div>

    <div class="container p-b-80">
        @if($wishlistItems->isEmpty())
            {{-- Wishlist vide --}}
            <div class="empty-wishlist">
                <div class="empty-icon">
                    <i class="zmdi zmdi-favorite-outline"></i>
                </div>
                <h3 class="mtext-103 cl5 p-b-10">Votre liste de favoris est vide</h3>
                <p class="stext-113 cl6 p-b-20">Explorez notre catalogue et ajoutez vos produits préférés</p>
                <a href="{{ route('client.product') }}" class="hero-cta" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #0066CC; padding: 0.8rem 2rem; border-radius: 48px; color: white; text-decoration: none;">
                    Découvrir nos produits <i class="zmdi zmdi-arrow-right"></i>
                </a>
            </div>
        @else
            {{-- Actions globales --}}
            <div class="wishlist-actions">
                <a href="{{ route('client.product') }}" class="btn-continue">
                    <i class="zmdi zmdi-arrow-left"></i> Continuer mes achats
                </a>
                <button id="btn-clear-wishlist" class="btn-clear-all">
                    <i class="zmdi zmdi-delete"></i> Tout supprimer
                </button>
            </div>

            <!-- Grille produits -->
            <div class="row" id="wishlist-grid">
                @foreach($wishlistItems as $index => $item)
                @php 
                    $product = $item->product;
                    $hasDiscount = $product->compare_price && $product->compare_price > $product->price;
                    $discountPercent = $hasDiscount ? round((($product->compare_price - $product->price) / $product->compare_price) * 100) : 0;
                    $stockStatus = $product->stock_quantity <= 0 ? 'out' : ($product->stock_quantity <= ($product->low_stock_threshold ?? 5) ? 'low' : 'in');
                @endphp
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 wishlist-card" data-product-id="{{ $product->id }}" style="animation-delay: {{ $index * 0.05 }}s">
                    <div class="modern-product-card">
                        {{-- Image --}}
                        <div class="product-image-wrapper">
                            @if($product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('frontend/images/no-image.jpg') }}" alt="No Image">
                            @endif
                            
                            {{-- Badge promo --}}
                            @if($hasDiscount)
                                <span class="product-badge sale">-{{ $discountPercent }}%</span>
                            @endif
                            
                            {{-- Bouton retirer --}}
                            <button type="button" class="btn-remove-wishlist" data-product-id="{{ $product->id }}" title="Retirer des favoris">
                                <i class="zmdi zmdi-favorite"></i>
                            </button>
                        </div>

                        {{-- Infos produit --}}
                        <div class="product-info">
                            @if($product->category)
                                <span class="product-category">{{ $product->category->name }}</span>
                            @endif
                            <h3 class="product-name">{{ $product->name }}</h3>
                            
                            <div class="product-price">
                                <span class="current-price">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                                @if($hasDiscount)
                                    <span class="old-price">{{ number_format($product->compare_price, 0, ',', ' ') }} FCFA</span>
                                @endif
                            </div>
                            
                            @if($product->colors->isNotEmpty())
                            <div class="product-colors">
                                @foreach($product->colors->take(4) as $color)
                                    <div class="color-dot" style="background-color: {{ $color->code }};" title="{{ $color->name }}"></div>
                                @endforeach
                                @if($product->colors->count() > 4)
                                    <span class="text-muted" style="font-size: 0.7rem;">+{{ $product->colors->count() - 4 }}</span>
                                @endif
                            </div>
                            @endif
                            
                            {{-- <div class="stock-status stock-{{ $stockStatus }}">
                                @if($stockStatus == 'in')
                                    <i class="zmdi zmdi-check-circle"></i> En stock
                                @elseif($stockStatus == 'low')
                                    <i class="zmdi zmdi-alert-circle"></i> Plus que {{ $product->stock_quantity }} en stock
                                @else
                                    <i class="zmdi zmdi-close-circle"></i> Rupture de stock
                                @endif
                            </div> --}}
                        </div>

                        {{-- Bouton panier --}}
                        <div class="cart-action">
                            @if($product->stock_quantity > 0)
                                <button type="button" class="btn-add-cart btn-addcart-wishlist" data-product-id="{{ $product->id }}">
                                    <i class="zmdi zmdi-shopping-cart"></i> Ajouter au panier
                                </button>
                            @else
                                <button type="button" class="btn-add-cart" disabled>
                                    <i class="zmdi zmdi-close"></i> Indisponible
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Load more (si nécessaire) -->
            @if($wishlistItems->count() > 12)
            <div class="flex-c-m flex-w w-full p-t-45">
                <button id="load-more-wishlist" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                    Charger plus <i class="zmdi zmdi-chevron-down m-l-8"></i>
                </button>
            </div>
            @endif
        @endif
    </div>

    @include('client.body.footer')
    @include('frontend.productModal')

    <!-- Scripts -->
    <script src="{{ asset('frontend/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/select2/select2.min.js') }}"></script>
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

        /* ── Retirer un article des favoris ─────────────────────── */
        $(document).on('click', '.btn-remove-wishlist', function () {
            const $btn = $(this);
            const productId = $btn.data('product-id');
            const $card = $btn.closest('.wishlist-card');
            
            swal({
                title: 'Retirer des favoris ?',
                text: 'Ce produit sera retiré de votre liste.',
                icon: 'warning',
                buttons: ['Annuler', 'Retirer'],
                dangerMode: true,
            }).then(function (confirmed) {
                if (!confirmed) return;
                
                $card.addClass('card-removing');
                
                $.ajax({
                    url: '{{ route("client.wishlist.remove") }}',
                    method: 'POST',
                    data: { product_id: productId, _token: TOKEN },
                    success: function (res) {
                        setTimeout(() => {
                            $card.remove();
                            updateWishlistBadge(res.count);
                            updateWishlistCount(res.count);
                            
                            if ($('.wishlist-card').length === 0) {
                                setTimeout(() => location.reload(), 300);
                            }
                        }, 300);
                    },
                    error: function(xhr) {
                        $card.removeClass('card-removing');
                        handleError(xhr);
                    }
                });
            });
        });

        /* ── Ajouter au panier depuis la wishlist ───────────────── */
        $(document).on('click', '.btn-addcart-wishlist', function () {
            const $btn = $(this);
            const productId = $btn.data('product-id');
            const originalHtml = $btn.html();

            $btn.html('<i class="zmdi zmdi-spinner zmdi-hc-spin"></i> Ajout...').prop('disabled', true);

            $.ajax({
                url: '{{ route("client.cart.add") }}',
                method: 'POST',
                data: { product_id: productId, quantity: 1, _token: TOKEN },
                success: function (res) {
                    $btn.html('<i class="zmdi zmdi-check"></i> Ajouté !').prop('disabled', false);
                    
                    // Notification
                    swal({
                        title: 'Ajouté au panier !',
                        text: 'Le produit a été ajouté avec succès.',
                        icon: 'success',
                        timer: 1500,
                        buttons: false
                    });
                    
                    setTimeout(() => {
                        $btn.html(originalHtml).prop('disabled', false);
                    }, 2000);
                    
                    // Mettre à jour le badge du panier
                    if (res.cart_count !== undefined) {
                        $('.js-show-cart').attr('data-notify', res.cart_count);
                        $('.cart-badge').text(res.cart_count);
                    }
                },
                error: function (xhr) {
                    $btn.html(originalHtml).prop('disabled', false);
                    if (xhr.status === 401) {
                        swal({
                            title: 'Connexion requise',
                            text: 'Veuillez vous connecter pour ajouter au panier',
                            icon: 'warning',
                            buttons: ['Annuler', 'Se connecter']
                        }).then(login => {
                            if (login) window.location.href = '{{ route("client.login") }}';
                        });
                    } else {
                        handleError(xhr);
                    }
                }
            });
        });

        /* ── Vider toute la wishlist ────────────────────────────── */
        $('#btn-clear-wishlist').on('click', function () {
            const remainingCount = $('.wishlist-card').length;
            
            swal({
                title: 'Vider tous les favoris ?',
                text: `Cette action supprimera ${remainingCount} article${remainingCount > 1 ? 's' : ''} de votre liste.`,
                icon: 'warning',
                buttons: ['Annuler', 'Oui, tout vider'],
                dangerMode: true,
            }).then(function (confirmed) {
                if (!confirmed) return;
                
                const $cards = $('.wishlist-card');
                const requests = [];
                
                $cards.each(function () {
                    const pid = $(this).data('product-id');
                    requests.push($.ajax({
                        url: '{{ route("client.wishlist.remove") }}',
                        method: 'POST',
                        data: { product_id: pid, _token: TOKEN }
                    }).catch(() => null));
                });
                
                $cards.addClass('card-removing');
                
                Promise.all(requests).then(() => {
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                });
            });
        });

        /* ── Load More (pagination simple) ──────────────────────── */
        let visibleCount = 12;
        const totalCards = $('.wishlist-card').length;
        
        $('#load-more-wishlist').on('click', function () {
            visibleCount += 8;
            $('.wishlist-card').each(function (index) {
                if (index < visibleCount) {
                    $(this).fadeIn(300);
                } else {
                    $(this).fadeOut(300);
                }
            });
            
            if (visibleCount >= totalCards) {
                $(this).fadeOut(300);
            }
        });
        
        // Initialisation : cacher les cartes au-delà de 12
        if (totalCards > 12) {
            $('.wishlist-card').each(function (index) {
                if (index >= 12) $(this).hide();
            });
        }

        /* ── Utilitaires ────────────────────────────────────────── */
        function updateWishlistBadge(count) {
            $('[href="{{ route("client.wishlist") }}"].icon-header-noti').attr('data-notify', count > 0 ? count : '');
            $('.nav-icon .fa-heart').parent().find('.cart-badge').remove();
            if (count > 0) {
                $('.nav-icon .fa-heart').parent().append(`<span class="cart-badge">${count}</span>`);
            }
        }
        
        function updateWishlistCount(count) {
            $('.wishlist-count').text(`(${count} article${count > 1 ? 's' : ''})`);
            if (count === 0) {
                $('.wishlist-count').hide();
            }
        }

        function handleError(xhr) {
            let message = 'Une erreur est survenue.';
            if (xhr.responseJSON?.message) message = xhr.responseJSON.message;
            swal('Erreur', message, 'error');
        }
    });
    </script>
</body>
</html>