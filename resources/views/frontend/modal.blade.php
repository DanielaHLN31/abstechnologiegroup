{{--
    ════════════════════════════════════════════════════════
    CART SIDEBAR — Fix overlay pleine largeur
    Le .s-full doit être un élément séparé du panneau,
    pas un enfant du conteneur droit.
    ════════════════════════════════════════════════════════
--}}

{{-- ── Overlay séparé (en dehors du panneau) ── --}}
<div class="cart-overlay js-hide-cart" id="cart-overlay"></div>

{{-- ── Panneau panier ── --}}
<div class="wrap-header-cart js-panel-cart">

    <div class="header-cart flex-col-l p-l-25 p-r-20">

        {{-- Titre --}}
        <div class="header-cart-title flex-w flex-sb-m p-b-20">
            <div class="cart-title-wrapper">
                <span class="mtext-103 cl2">Mon Panier</span>
                {{-- <span class="cart-item-count" id="sidebar-cart-count">0 article</span> --}}
            </div>
            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        {{-- Contenu scrollable --}}
        <div class="header-cart-content flex-w js-pscroll">

            {{-- Liste des articles --}}
            <ul class="header-cart-wrapitem w-full" id="sidebar-cart-items">
                {{-- Rempli dynamiquement par JS --}}
            </ul>

            {{-- Pied : total + boutons --}}
            <div class="w-full" id="sidebar-cart-footer" style="display:none;">
                <div class="header-cart-total w-full p-tb-30">
                    <div class="total-wrapper">
                        <span class="total-label">Total</span>
                        <span class="total-amount" id="sidebar-cart-total">0 FCFA</span>
                    </div>
                </div>
                <div class="header-cart-buttons flex-w w-full">
                    <a href="{{ route('client.cart') }}" class="cart-btn cart-btn-outline">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                            <line x1="3" y1="6" x2="21" y2="6"/>
                        </svg>
                        Voir le panier
                    </a>
                    <a href="{{ route('client.checkout') }}" class="cart-btn cart-btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                        Commander
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* ══════════════════════════════════════════════
    OVERLAY — pleine page, indépendant du panneau
    ══════════════════════════════════════════════ */
    .cart-overlay {
        position: fixed;
        inset: 0;
        background: rgba(5, 12, 30, 0.55);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 9998;
        opacity: 0;
        visibility: hidden;
        transition: opacity .35s ease, visibility .35s;
        cursor: pointer;
    }
    .cart-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* ══════════════════════════════════════════════
    PANNEAU PANIER
    ══════════════════════════════════════════════ */
    .wrap-header-cart {
        position: fixed;
        inset: 0;
        width: 100% !important;
        height: 100vh !important;
        z-index: 9999;
        background-color: transparent;
        visibility: hidden;
        pointer-events: none;  /* Le wrapper ne bloque pas les clics vers l'overlay */
        transition: visibility .4s;
    }
    .wrap-header-cart.show-header-cart {
        visibility: visible;
        pointer-events: auto;  /* Quand ouvert, le wrapper reçoit les clics */
    }


    /* ── Conteneur blanc ── */
    .header-cart {
        position: absolute;
        top: 0;
        right: -450px;
        width: 420px;
        max-width: 100%;
        height: 100%;
        background: #fff;
        z-index: 1;
        transition: right .4s cubic-bezier(.4,0,.2,1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        pointer-events: auto;  /* Le panneau reçoit les clics */
    }
    /* ── Titre ── */
    .header-cart-title {
        padding: 24px 25px 16px;
        border-bottom: 1px solid #f0f4fb;
        flex-shrink: 0;
    }
    .cart-title-wrapper {
        display: flex; flex-direction: column; gap: 3px;
    }
    .cart-title-wrapper .mtext-103 {
        font-family: 'Montserrat', sans-serif;
        font-size: 18px; font-weight: 800;
        color: #0a1628;
    }
    .cart-item-count {
        font-size: 12px; color: #9aaccc; font-weight: 400;
        letter-spacing: .04em;
    }
    .js-hide-cart {
        cursor: pointer;
        width: 34px; height: 34px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; transition: all .2s;
    }
    .js-hide-cart:hover {
        background: #f4f7fd;
        transform: rotate(90deg);
    }

    /* ── Contenu scrollable ── */
    .header-cart-content {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 0 0 20px;
    }
    .header-cart-content::-webkit-scrollbar { width: 3px; }
    .header-cart-content::-webkit-scrollbar-track { background: transparent; }
    .header-cart-content::-webkit-scrollbar-thumb { background: #dde6f5; border-radius: 4px; }
    .header-cart-content::-webkit-scrollbar-thumb:hover { background: #0066CC; }

    .header-cart-wrapitem {
        padding: 8px 20px 0; margin: 0; list-style: none;
        flex: 1;
    }

    /* ── Article ── */
    .header-cart-item {
        display: flex; align-items: center; gap: 14px;
        padding: 13px 0;
        border-bottom: 1px solid #f4f7fd;
        animation: cart-item-in .3s ease-out both;
        transition: background .15s;
    }
    @keyframes cart-item-in {
        from { opacity:0; transform:translateX(16px); }
        to   { opacity:1; transform:translateX(0); }
    }
    .header-cart-item:last-child { border-bottom: none; }

    .header-cart-item-img { flex-shrink: 0; }
    .header-cart-item-img img {
        width: 72px; height: 72px;
        object-fit: cover; border-radius: 10px;
        background: #f4f7fd;
        border: 1px solid #eef2fb;
    }

    .header-cart-item-txt { flex: 1; min-width: 0; }
    .header-cart-item-name {
        font-size: 13px; font-weight: 600; color: #0a1628;
        text-decoration: none; display: block;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        margin-bottom: 6px; transition: color .2s;
    }
    .header-cart-item-name:hover { color: #0066CC; }
    .header-cart-item-info {
        font-size: 12px; color: #6b7a99;
        display: flex; align-items: center; gap: 5px; flex-wrap: wrap;
    }
    .sidebar-color-dot {
        display: inline-block; width: 11px; height: 11px;
        border-radius: 50%; border: 1px solid rgba(0,0,0,.1);
        flex-shrink: 0;
    }

    .sidebar-cart-remove {
        background: none; border: none; color: #c8d4e8;
        cursor: pointer; padding: 7px; border-radius: 50%;
        transition: all .2s; flex-shrink: 0;
        width: 30px; height: 30px;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
    }
    .sidebar-cart-remove:hover {
        background: #feebeb; color: #CC1E1E; transform: scale(1.08);
    }

    /* ── État vide ── */
    .header-cart-empty {
        text-align: center; padding: 52px 24px;
        display: flex; flex-direction: column; align-items: center; gap: 0;
    }
    .empty-cart-icon {
        width: 72px; height: 72px; border-radius: 50%;
        background: #f4f7fd; border: 1px solid #eef2fb;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 16px; font-size: 32px; color: #c8d4e8;
    }
    .header-cart-empty p { font-size: 14px; color: #9aaccc; margin-bottom: 18px; }
    .empty-cart-cta {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 10px 22px; background: #0066CC; color: #fff !important;
        text-decoration: none !important; border-radius: 20px;
        font-size: 13px; font-weight: 600; letter-spacing: .03em;
        transition: background .2s, transform .2s;
    }
    .empty-cart-cta:hover { background: #0066CC; transform: translateY(-2px); }

    /* ── Loader ── */
    .sidebar-cart-loader {
        text-align: center; padding: 44px 20px;
        color: #9aaccc; font-size: 13px;
        display: flex; flex-direction: column; align-items: center; gap: 12px;
    }
    .sidebar-cart-loader i {
        font-size: 28px; color: #0066CC;
        animation: cart-spin .7s linear infinite;
    }
    @keyframes cart-spin { to { transform: rotate(360deg); } }

    /* ── Pied ── */
    .header-cart-total {
        padding: 18px 20px !important;
        border-top: 1px solid #f0f4fb;
    }
    .total-wrapper {
        display: flex; justify-content: space-between; align-items: baseline;
    }
    .total-label { font-size: 13px; color: #6b7a99; font-weight: 500; }
    .total-amount {
        font-family: 'Montserrat', sans-serif;
        font-size: 20px; font-weight: 800; color: #0a1628;
    }

    .header-cart-buttons {
        display: flex; gap: 10px;
        padding: 0 20px 24px;
    }
    .cart-btn {
        flex: 1; display: inline-flex; align-items: center; justify-content: center;
        gap: 8px; padding: 12px 16px; border-radius: 12px;
        font-size: 13px; font-weight: 600; text-decoration: none !important;
        transition: all .25s; cursor: pointer; white-space: nowrap;
    }
    .cart-btn-outline {
        background: #f4f7fd; border: 1.5px solid #e0e8f4; color: #0a1628 !important;
    }
    .cart-btn-outline:hover {
        border-color: rgba(0,102,204,.4); color: #0066CC !important;
        transform: translateY(-2px);
    }
    .cart-btn-primary {
        background: #0066CC; border: none; color: #fff !important;
        box-shadow: 0 4px 14px rgba(0,102,204,.3);
    }
    .cart-btn-primary:hover {
        background: #004FA3; transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(0,102,204,.4);
        color: #fff !important;
    }

    /* ── Responsive ── */
    @media (max-width: 480px) {
        .wrap-header-cart { width: 100%; }
        .header-cart-item-img img { width: 60px; height: 60px; }
        .total-amount { font-size: 18px; }
    }
</style>

<script>
    (function () {

        /* ── Ouvrir / fermer le panneau + overlay ── */
        var $panel   = $('.js-panel-cart');
        var $overlay = $('#cart-overlay');

        function openCart() {
            $panel.addClass('show-header-cart');
            $overlay.addClass('active');
            document.body.style.overflow = 'hidden';   /* bloque le scroll page */
        }

        function closeCart() {
            $panel.removeClass('show-header-cart');
            $overlay.removeClass('active');
            document.body.style.overflow = '';
        }

        /* Ouvrir au clic sur l'icône panier */
        $(document).on('click', '.js-show-cart', function () {
            openCart();
            if (typeof loadSidebarCart === 'function') loadSidebarCart();
        });

        /* Fermer via l'overlay ou les boutons .js-hide-cart */
        $(document).on('click', '.js-hide-cart, #cart-overlay', function () {
            closeCart();
        });

        /* Fermer avec Échap */
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') closeCart();
        });

        /* ── Compteur titre ── */
        // window.updateCartSidebarCount = function (count) {
        //     var text = count <= 0 ? '0 article'
        //             : count === 1 ? '1 article'
        //             : count + ' articles';
        //     $('#sidebar-cart-count').text(text);
        // };

        /* ── Render ── */
        window.renderSidebarCart = function (items, total, count) {
            var $list   = $('#sidebar-cart-items');
            var $footer = $('#sidebar-cart-footer');

            $list.html('');
            // updateCartSidebarCount(count || 0);

            if (!items || !items.length) {
                $list.html(`
                    <li class="header-cart-empty">
                        <div class="empty-cart-icon"><i class="zmdi zmdi-shopping-cart"></i></div>
                        <p>Votre panier est vide.</p>
                        <a href="{{ route('client.product') }}" class="empty-cart-cta">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            Découvrir nos produits
                        </a>
                    </li>`);
                $footer.hide();
                if (typeof updateHeaderBadge === 'function') updateHeaderBadge(0);
                return;
            }

            $footer.show();

            items.forEach(function (item) {
                var imgSrc    = item.image ? '/storage/' + item.image : '/frontend/images/no-image.jpg';
                var colorHtml = item.color
                    ? '<span class="sidebar-color-dot" style="background:' + item.color.code + '"></span>'
                    + '<span>' + item.color.name + '</span>'
                    + '<span style="color:#d0d8eb">·</span>'
                    : '';

                $list.append(`
                    <li class="header-cart-item" data-item-id="${item.id}">
                        <div class="header-cart-item-img">
                            <img src="${imgSrc}" alt="${item.name}" loading="lazy">
                        </div>
                        <div class="header-cart-item-txt">
                            <a href="/client/product/detail/${item.product_id}"
                            class="header-cart-item-name">${item.name}</a>
                            <span class="header-cart-item-info">
                                ${colorHtml}
                                ${item.quantity} × ${fmtPrice(item.price)} FCFA
                            </span>
                        </div>
                        <button type="button" class="sidebar-cart-remove"
                                data-item-id="${item.id}" title="Supprimer">
                            <i class="zmdi zmdi-close"></i>
                        </button>
                    </li>`);
            });

            $('#sidebar-cart-total').text(fmtPrice(total) + ' FCFA');
            if (typeof updateHeaderBadge === 'function') updateHeaderBadge(count);
        };

        /* ── Supprimer un article ── */
        $(document).on('click', '.sidebar-cart-remove', function () {
            var itemId = $(this).data('item-id');
            var $li    = $(this).closest('li');
            $li.css({ opacity: .4, transition: 'opacity .2s' });

            $.ajax({
                url   : '{{ route("client.cart.remove") }}',
                method: 'POST',
                data  : { item_id: itemId, _token: '{{ csrf_token() }}' },
                success: function () {
                    $li.slideUp(250, function () {
                        $(this).remove();
                        if (typeof loadSidebarCart === 'function') loadSidebarCart();
                    });
                },
                error: function () {
                    $li.css('opacity', 1);
                    if (typeof toastr !== 'undefined')
                        toastr.error('Impossible de supprimer cet article.', 'Erreur');
                }
            });
        });

    })();
</script>