
	<!-- Toastr JS (après jQuery) -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
	// ── Configuration Toastr ──────────────────────────────────────
    toastr.options = {
        closeButton       : true,
        progressBar       : true,
        positionClass     : 'toast-bottom-right',
        timeOut           : 3500,
        extendedTimeOut   : 1000,
        showEasing        : 'swing',
        hideEasing        : 'linear',
        showMethod        : 'fadeIn',
        hideMethod        : 'fadeOut'
    };
// {{-- ================================================================
//      SCRIPT QUICK VIEW
//      ================================================================ --}}
	
$(document).ready(function () {

        
    let currentProductId = null;
    let selectedColorId  = null;

    // OUVERTURE — clic sur "Quick View"
    $(document).on('click', '.js-show-modal1', function (e) {
        e.preventDefault();

        // Sauvegarder l'ID AVANT resetModal()
        const productId = $(this).data('product-id');
        selectedColorId = null;

        resetModal(); // ne touche plus à productId car c'est une variable locale

        // Réassigner après resetModal
        currentProductId = productId;

        if (!currentProductId) {
            showModalError('ID produit invalide');
            return;
        }

        $('.js-modal1').addClass('show-modal1');
        $('#modal1-loader').show();
        $('#modal1-content').hide();

        $.ajax({
            url: '/client/products/' + currentProductId,  // ← sans "s"
            method: 'GET',
            success: function (response) {
                const p = response.product || response;
                if (!p) { showModalError('Produit introuvable.'); return; }
                fillModal(p);
            },
            error: function () {
                showModalError('Impossible de charger ce produit.');
            }
        });
    });

    // Fermer le modal
    $(document).on('click', '.js-hide-modal1, .overlay-modal1', function () {
        $('.js-modal1').removeClass('show-modal1');
    });

    // ================================================================
    // REMPLISSAGE DU MODAL
    // ================================================================
    
    function fillModal(p) {
        $('#modal1-loader').hide();
        $('#modal1-content').show();

        // CORRECTION 2: Générez l'URL correctement
        // Utilisez une concaténation simple
        $('#modal1-detail-link').attr('href', '/client/product/detail/' + p.id);
        
        // ── Badges ───────────────────────────────────────────────────
        let badges = '';
        if (p.is_featured) badges += '<span class="modal1-badge modal1-badge-featured">⭐ Coup de cœur</span>';
        if (isNew(p.created_at)) badges += '<span class="modal1-badge modal1-badge-new">Nouveau</span>';
        $('#modal1-badges').html(badges);

        // ── Nom ───────────────────────────────────────────────────────
        $('#modal1-name').text(p.name);

        // ── Prix ──────────────────────────────────────────────────────
        let priceHtml = '';
        if (p.compare_price && parseFloat(p.compare_price) > parseFloat(p.price)) {
            const pct = Math.round((1 - p.price / p.compare_price) * 100);
            priceHtml = `
                <span class="modal1-price-old">${fmt(p.compare_price)} FCFA</span>
                <span class="modal1-price-main">${fmt(p.price)} FCFA</span>
                <span class="modal1-discount">−${pct}%</span>`;
        } else {
            priceHtml = `<span class="modal1-price-main">${fmt(p.price)} FCFA</span>`;
        }
        $('#modal1-price').html(priceHtml);

        // ── Catégorie & Marque ────────────────────────────────────────
        let metaHtml = '';
        if (p.category) metaHtml += `<span class="modal1-meta-item"><strong>Catégorie :</strong> ${p.category.name}</span>`;
        if (p.brand)    metaHtml += `<span class="modal1-meta-item"><strong>Marque :</strong> ${p.brand.name}</span>`;
        $('#modal1-meta').html(metaHtml || '');

        // ── Description ───────────────────────────────────────────────
        $('#modal1-desc').html(p.description || '<em>Aucune description</em>');

        // ── Images → Slick ────────────────────────────────────────────
        buildSlick(p.images || []);

        // ── Couleurs ──────────────────────────────────────────────────
        if (p.colors && p.colors.length > 0) {
            let colorsHtml = '';
            p.colors.forEach(function (c) {
                const stock = c.pivot ? c.pivot.stock_quantity : 0;
                const stockLabel = stock > 0 ? `<span class="modal1-color-stock">(${stock})</span>` : `<span class="modal1-color-stock" style="color:#e65540">(épuisé)</span>`;
                const disabled = stock === 0 ? 'style="opacity:.45;cursor:not-allowed"' : '';
                colorsHtml += `
                    <button type="button" class="modal1-color-btn"
                            data-color-id="${c.id}"
                            data-color-name="${c.name}"
                            data-stock="${stock}"
                            ${disabled}>
                        <span class="modal1-color-dot" style="background:${c.code}"></span>
                        ${c.name}
                        ${stockLabel}
                    </button>`;
            });
            $('#modal1-colors-list').html(colorsHtml);
            $('#modal1-colors-wrap').show();
        } else {
            $('#modal1-colors-wrap').hide();
        }

        // ── Spécifications ────────────────────────────────────────────
        if (p.specifications && p.specifications.length > 0) {
            let specsHtml = '';
            p.specifications.forEach(function (sp) {
                specsHtml += `
                    <div class="modal1-spec-row">
                        <span class="modal1-spec-key">${sp.name}</span>
                        <span class="modal1-spec-val">${sp.value || '—'}</span>
                    </div>`;
            });
            $('#modal1-specs-list').html(specsHtml);
            $('#modal1-specs-wrap').show();
        } else {
            $('#modal1-specs-wrap').hide();
        }

        // ── Stock global ──────────────────────────────────────────────
        updateStockDisplay(p.stock_quantity, p.low_stock_threshold);

        // ── Stocker l'ID pour l'ajout au panier ──────────────────────
        $('#modal1-add-cart').data('product-id', p.id);
    }

    // ================================================================
    // GALERIE SLICK
    // ================================================================
    function buildSlick(images) {
        const $main   = $('#modal1-slick');
        const $thumbs = $('#modal1-thumbs');

        // Détruire les instances existantes
        if ($main.hasClass('slick-initialized'))   $main.slick('unslick');
        if ($thumbs.hasClass('slick-initialized')) $thumbs.slick('unslick');

        $main.html('');
        $thumbs.html('');

        if (images.length === 0) {
            $main.html(`
                <div class="item-slick3">
                    <div class="wrap-pic-w pos-relative txt-center p-t-60 p-b-60">
                        <i class="zmdi zmdi-image-alt" style="font-size:60px;color:#ddd"></i>
                        <p class="stext-107 cl6 p-t-10">Aucune image</p>
                    </div>
                </div>`);
            setTimeout(() => {
                $main.slick({ slidesToShow:1, slidesToScroll:1, arrows:false, dots:false });
            }, 80);
            return;
        }

        // Construire l'image principale (Slick simple)
        let mainHtml = '';
        images.forEach(function (img, index) {
            const src = '/storage/' + img.image_path;
            mainHtml += `
                <div class="item-slick3">
                    <div class="wrap-pic-w pos-relative">
                        <img src="${src}" alt="Image produit"
                            style="width:100%;height:380px;object-fit:contain;display:block;">
                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                        href="${src}">
                            <i class="fa fa-expand"></i>
                        </a>
                    </div>
                </div>`;
        });
        $main.html(mainHtml);

        // Construire les thumbnails MANUELLEMENT (pas de Slick)
        let thumbsHtml = '';
        images.forEach(function (img, index) {
            const src = '/storage/' + img.image_path;
            thumbsHtml += `
                <div class="modal1-thumb-item ${index === 0 ? 'active' : ''}" 
                    data-index="${index}"
                    style="
                        width:80px; height:80px; 
                        margin-bottom:8px; 
                        cursor:pointer; 
                        border:2px solid ${index === 0 ? '#717fe0' : '#e0e0e0'}; 
                        border-radius:4px; 
                        overflow:hidden;
                        flex-shrink:0;
                    ">
                    <img src="${src}" alt="thumb"
                        style="width:100%;height:100%;object-fit:cover;display:block;">
                </div>`;
        });
        $thumbs.html(thumbsHtml);
        $thumbs.css({
            'display'        : 'flex',
            'flex-direction' : 'column',
            'align-items'    : 'center',
            'width'          : '90px',
            'max-height'     : '380px',
            'overflow-y'     : 'auto',
            'scrollbar-width': 'none',
        });

        setTimeout(function () {
            // Slick UNIQUEMENT sur l'image principale
            $main.slick({
                slidesToShow   : 1,
                slidesToScroll : 1,
                fade           : true,
                arrows         : true,
                dots           : false,
                prevArrow      : '<button class="arrow-slick3 prev-slick3"><i class="fa fa-angle-left"></i></button>',
                nextArrow      : '<button class="arrow-slick3 next-slick3"><i class="fa fa-angle-right"></i></button>',
            });

            // Sync : clic sur thumbnail → changer slide principal
            $(document).on('click', '.modal1-thumb-item', function () {
                const index = parseInt($(this).data('index'));
                
                // Mettre à jour les bordures
                $('.modal1-thumb-item').css('border-color', '#e0e0e0');
                $(this).css('border-color', '#717fe0');
                
                // Aller au slide correspondant
                $main.slick('slickGoTo', index);
            });

            // Sync : changement de slide → mettre à jour le thumbnail actif
            $main.on('afterChange', function (e, slick, currentSlide) {
                $('.modal1-thumb-item').css('border-color', '#e0e0e0');
                $(`.modal1-thumb-item[data-index="${currentSlide}"]`).css('border-color', '#717fe0');
                
                // Scroll automatique vers le thumb visible
                const $activThumb = $(`.modal1-thumb-item[data-index="${currentSlide}"]`);
                if ($activThumb.length) {
                    $thumbs[0].scrollTop = $activThumb[0].offsetTop - $thumbs[0].offsetTop - 10;
                }
            });

            // MagnificPopup zoom
            $main.magnificPopup({
                delegate  : 'a',
                type      : 'image',
                gallery   : { enabled: true },
                mainClass : 'mfp-fade'
            });

        }, 80);
    }
    // ================================================================
    // SÉLECTION D'UNE COULEUR
    // ================================================================
    $(document).on('click', '.modal1-color-btn', function () {
        if ($(this).data('stock') === 0) return; // épuisée → ignorer

        $('.modal1-color-btn').removeClass('active');
        $(this).addClass('active');

        selectedColorId = $(this).data('color-id');
        const stock     = $(this).data('stock');
        const threshold = 5; // seuil bas par défaut si pas dispo ici
        updateStockDisplay(stock, threshold);
    });

    // ================================================================
    // QUANTITÉ
    // ================================================================
    $(document).on('click', '#modal1-qty-up', function () {
        const $q = $('#modal1-qty');
        $q.val(parseInt($q.val() || 1) + 1);
    });

    $(document).on('click', '#modal1-qty-down', function () {
        const $q = $('#modal1-qty');
        const v  = parseInt($q.val() || 1);
        if (v > 1) $q.val(v - 1);
    });

    // ================================================================
    // AJOUTER AU PANIER
    // ================================================================
    $(document).on('click', '#modal1-add-cart', function () {
        const productId = $(this).data('product-id');
        const qty       = parseInt($('#modal1-qty').val()) || 1;

        // Si des couleurs existent, en forcer le choix
        if ($('#modal1-colors-wrap').is(':visible') && !selectedColorId) {
            // Mettre en évidence les couleurs
            $('#modal1-colors-list').css('animation', 'none');
            setTimeout(() => {
                $('#modal1-colors-list').css({
                    'outline': '2px solid #e65540',
                    'border-radius': '6px',
                    'padding': '4px'
                });
                setTimeout(() => $('#modal1-colors-list').css({ 'outline': '', 'padding': '' }), 1500);
            }, 10);

            toastr.warning('Veuillez choisir une couleur avant d\'ajouter au panier.', 'Couleur requise');
            return;
        }

        const $btn = $(this);
        $btn.text('Ajout...').prop('disabled', true);

        $.ajax({
            url: '/client/cart/add',
            method: 'POST',
            data: {
                product_id: productId,
                quantity:   qty,
                color_id:   selectedColorId || '',
                _token:     '{{ csrf_token() }}'
            },
            success: function (response) {
                $btn.text('Ajouter au panier').prop('disabled', false);

                toastr.success(response.message || 'Produit ajouté au panier.', 'Ajouté !');

                // Mettre à jour le compteur du panier dans le header
                if (response.cart_count !== undefined) {
                    $('.js-show-cart').attr('data-notify', response.cart_count);
                }
            },
            error: function (xhr) {
                $btn.text('Ajouter au panier').prop('disabled', false);
                const msg = xhr.responseJSON?.message || 'Erreur lors de l\'ajout.';
                toastr.error(msg, 'Erreur');
            }
        });
    });

    // ================================================================
    // WISHLIST
    // ================================================================
    $(document).on('click', '.js-addwish-detail', function (e) {
        e.preventDefault();
        if (!currentProductId) return;

        $.ajax({
            url: '/client/wishlist/add',
            method: 'POST',
            data: { product_id: currentProductId, _token: '{{ csrf_token() }}' },
            success: function (response) {
                toastr.info('Produit retiré de vos favoris.', 'Favoris');
            },
            error: function () {
                toastr.error('Impossible d\'ajouter aux favoris.', 'Erreur');
            }
        });
    });

    // ================================================================
    // UTILITAIRES
    // ================================================================
    function resetModal() {
        currentProductId = null;
        selectedColorId  = null;
        
        // Détruire le listener thumbnail pour éviter les doublons
        $(document).off('click', '.modal1-thumb-item');
        
        $('#modal1-badges, #modal1-name, #modal1-price, #modal1-meta, #modal1-desc, #modal1-colors-list, #modal1-specs-list, #modal1-stock').html('');
        $('#modal1-colors-wrap, #modal1-specs-wrap').hide();
        $('#modal1-qty').val(1);

        const $slick = $('#modal1-slick');
        if ($slick.hasClass('slick-initialized')) $slick.slick('unslick');
        $slick.html('');
        $('#modal1-thumbs').html('');
    }

    function showModalError(msg) {
        $('#modal1-loader').hide();
        $('#modal1-content').show();
        $('#modal1-name').text('Erreur');
        $('#modal1-desc').html('<span style="color:#e65540">' + msg + '</span>');
    }

    function updateStockDisplay(qty, threshold) {
        let html = '';
        qty = parseInt(qty) || 0;
        threshold = parseInt(threshold) || 5;

        if (qty <= 0) {
            html = '<span class="modal1-stock-rupture"><i class="zmdi zmdi-close-circle m-r-5"></i>Rupture de stock</span>';
            $('#modal1-add-cart').prop('disabled', true).css('opacity', .5);
        } else if (qty <= threshold) {
            html = `<span class="modal1-stock-low"><i class="zmdi zmdi-alert-triangle m-r-5"></i>Stock limité — ${qty} disponible${qty > 1 ? 's' : ''}</span>`;
            $('#modal1-add-cart').prop('disabled', false).css('opacity', 1);
        } else {
            html = `<span class="modal1-stock-ok"><i class="zmdi zmdi-check m-r-5"></i>En stock (${qty} unités)</span>`;
            $('#modal1-add-cart').prop('disabled', false).css('opacity', 1);
        }
        $('#modal1-stock').html(html);
    }

    function fmt(n) {
        return parseFloat(n).toLocaleString('fr-FR');
    }

    function isNew(dateStr) {
        if (!dateStr) return false;
        const days = (Date.now() - new Date(dateStr).getTime()) / 86400000;
        return days <= 30;
    }

    // Charger le panier dès l'ouverture du sidebar
    $(document).on('click', '.js-show-cart', function () {
        loadSidebarCart();
    });

    // ── Chargement AJAX ─────────────────────────────────────────
    function loadSidebarCart() {
        const $list   = $('#sidebar-cart-items');
        const $footer = $('#sidebar-cart-footer');

        $list.html(`
            <li class="sidebar-cart-loader">
                <i class="zmdi zmdi-rotate-right zmdi-hc-spin"></i>
                Chargement...
            </li>`);

        $.ajax({
            url: '{{ route("client.cart.sidebar") }}',
            method: 'GET',
            success: function (res) {
                renderSidebarCart(res.items, res.total, res.count);
            },
            error: function () {
                $list.html('<li class="sidebar-cart-loader"><i class="zmdi zmdi-alert-circle"></i>Erreur de chargement.</li>');
            }
        });
    }

    // ── Rendu HTML ───────────────────────────────────────────────
    function renderSidebarCart(items, total, count) {
        const $list = $('#sidebar-cart-items');
        $list.html('');

        if (!items || items.length === 0) {
            $list.html(`
                <li class="txt-center p-t-30 p-b-10">
                    <i class="zmdi zmdi-shopping-cart" style="font-size:40px;color:#ddd"></i>
                    <p class="stext-107 cl6 p-t-10">Votre panier est vide.</p>
                </li>`);
            $('#sidebar-cart-total').text('0 FCFA');
            updateHeaderBadge(0);
            return;
        }

        items.forEach(function (item) {
            const imgSrc = item.image
                ? '/storage/' + item.image
                : '/frontend/images/no-image.jpg';

            const colorHtml = item.color
                ? `<span class="sidebar-color-dot" style="background:${item.color.code}"></span>${item.color.name} · `
                : '';

            $list.append(`
                <li class="header-cart-item flex-w flex-t m-b-12" data-item-id="${item.id}">
                    <div class="header-cart-item-img">
                        <img src="${imgSrc}" alt="${item.name}">
                    </div>
                    <div class="header-cart-item-txt p-t-8" style="flex:1;min-width:0">
                        <a href="/client/product/detail/${item.product_id}"
                           class="header-cart-item-name m-b-18 hov-cl1 trans-04"
                           style="display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                            ${item.name}
                        </a>
                        <span class="header-cart-item-info">
                            ${colorHtml}${item.quantity} × ${fmtPrice(item.price)} FCFA
                        </span>
                    </div>
                    <button type="button"
                            class="sidebar-cart-remove"
                            data-item-id="${item.id}"
                            title="Supprimer">
                        <i class="zmdi zmdi-close"></i>
                    </button>
                </li>`);
        });

        $('#sidebar-cart-total').text(fmtPrice(total) + ' FCFA');
        updateHeaderBadge(count);
    }

    // ── Supprimer depuis le sidebar ──────────────────────────────
    $(document).on('click', '.sidebar-cart-remove', function () {
        const itemId = $(this).data('item-id');
        const $li    = $(this).closest('li');

        $li.css('opacity', .4);

        $.ajax({
            url: '{{ route("client.cart.remove") }}',
            method: 'POST',
            data: { item_id: itemId, _token: '{{ csrf_token() }}' },
            success: function (res) {
                $li.fadeOut(250, function () {
                    $(this).remove();
                    // Recharger pour avoir le rendu à jour
                    loadSidebarCart();
                });
                // Mettre aussi à jour la page panier si ouverte
                if (typeof refreshCartPage === 'function') refreshCartPage();
            },
            error: function () {
                $li.css('opacity', 1);
                toastr.error('Impossible de supprimer cet article.', 'Erreur');
            }
        });
    });

    // ── Mise à jour automatique après "Ajouter au panier" ────────
    // Le CartController répond avec cart_count ; on recharge le sidebar
    // si le panneau est déjà ouvert.
    $(document).ajaxSuccess(function (e, xhr, settings) {
        // Détecter les appels vers /cart/add
        if (settings.url && settings.url.includes('/cart/add')) {
            const res = xhr.responseJSON;
            if (res && res.cart_count !== undefined) {
                updateHeaderBadge(res.cart_count);
                // Si le sidebar est visible, le rafraîchir
                if ($('.js-panel-cart').hasClass('show-header-cart')) {
                    loadSidebarCart();
                }
            }
        }
    });

    // ── Utilitaires ──────────────────────────────────────────────
    function fmtPrice(n) {
        return parseFloat(n).toLocaleString('fr-FR');
    }

    function updateHeaderBadge(count) {
        const val = count > 0 ? count : '';
        $('.js-show-cart').attr('data-notify', val);
    }


    const TOKEN   = '{{ csrf_token() }}';
    const IS_AUTH = {{ auth()->check() ? 'true' : 'false' }};
    const LOGIN_URL = '{{ route("client.login") }}';

    // ================================================================
    // 0. HELPER CENTRALISÉ : redirection si non connecté
    // ================================================================
    function requireAuth(callback) {
        if (!IS_AUTH) {
            // swal({
            //     title: 'Connexion requise',
            //     text: 'Veuillez vous connecter pour continuer.',
            //     icon: 'info',
            //     buttons: {
            //         cancel: 'Annuler',
            //         confirm: { text: 'Se connecter', value: true }
            //     }
            // }).then(function (val) {
                 window.location.href = LOGIN_URL;
            // });
            return false;
        }
        callback();
        return true;
    }

    // ================================================================
    // 1. WISHLIST — boutons cœur (.js-addwish-b2)
    //    Remplace le comportement sweetalert statique du main.js
    // ================================================================

    // Charger les IDs déjà en favoris pour colorer les cœurs actifs
    if (IS_AUTH) {
        $.getJSON('{{ route("client.wishlist.ids") }}', function (res) {
            (res.ids || []).forEach(function (pid) {
                $(`.js-addwish-b2[data-product-id="${pid}"]`).addClass('js-addedwish-b2');
            });
        });
    }

    $(document).on('click', '.js-addwish-b2', function (e) {
        e.preventDefault();
        const $btn      = $(this);
        const productId = $btn.data('product-id');
        if (!productId) return;

        requireAuth(function () {
            $.ajax({
                url: '{{ route("client.wishlist.toggle") }}',
                method: 'POST',
                data: { product_id: productId, _token: TOKEN },
                success: function (res) {
                    if (res.status === 'added') {
                        $btn.addClass('js-addedwish-b2');
                        toastr.success('Produit ajouté à vos favoris !', 'Favoris');
                    } else {
                        $btn.removeClass('js-addedwish-b2');
                        toastr.info('Produit retiré de vos favoris.', 'Favoris');
                    }
                    updateWishlistBadge(res.count);
                },
                error: handleAjaxError
            });
        });
    });

    function updateWishlistBadge(count) {
        $('a[href="{{ route("client.wishlist") }}"].icon-header-noti').attr('data-notify', count > 0 ? count : '');
    }

    // ================================================================
    // 2. PANIER — intercepter "Ajouter au panier" si non connecté
    //    (le modal quick view déclenche #modal1-add-cart)
    // ================================================================

    $(document).on('click', '#modal1-add-cart', function (e) {
        if (!IS_AUTH) {
            e.stopImmediatePropagation(); // bloquer le handler du modal
            requireAuth(function () {});
        }
        // Si connecté → le handler du modal prend le relais normalement
    }, true); // capture phase pour passer avant le handler du modal

    // Bouton "Ajouter au panier" sur la page wishlist
    $(document).on('click', '.btn-addcart-wishlist', function () {
        if (!IS_AUTH) {
            requireAuth(function () {});
            return false;
        }
    });

    // ================================================================
    // 3. BARRE DE RECHERCHE — suggestions autocomplete
    //    S'applique à l'input .plh3 (modal de recherche du header)
    // ================================================================

    let searchTimer = null;
    const $searchInput = $('input[name="q"].plh3');

    // Créer le conteneur de suggestions
    $searchInput.closest('form').css('position', 'relative');
    const $suggestions = $('<div id="search-suggestions"></div>').css({
        position:   'absolute',
        top:        '100%',
        left:       0,
        right:      0,
        background: '#fff',
        border:     '1px solid #e6e6e6',
        borderTop:  'none',
        zIndex:     9999,
        maxHeight:  '360px',
        overflowY:  'auto',
        boxShadow:  '0 8px 24px rgba(0,0,0,.1)',
        borderRadius: '0 0 6px 6px',
        display:    'none',
    }).insertAfter($searchInput);

    $searchInput.on('input', function () {
        clearTimeout(searchTimer);
        const q = $(this).val().trim();

        if (q.length < 2) { $suggestions.hide().html(''); return; }

        searchTimer = setTimeout(function () {
            $.getJSON('{{ route("client.search.suggest") }}', { q: q }, function (results) {
                if (!results.length) { $suggestions.hide().html(''); return; }

                let html = '';
                results.forEach(function (item) {
                    html += `
                        <a href="${item.url}" class="search-suggest-item"
                           style="display:flex;align-items:center;gap:12px;padding:10px 16px;
                                  text-decoration:none;color:#333;border-bottom:1px solid #f5f5f5;
                                  transition:background .15s">
                            <img src="${item.image}" alt="${item.name}"
                                 style="width:44px;height:44px;object-fit:cover;border-radius:4px;flex-shrink:0">
                            <div style="flex:1;min-width:0">
                                <div style="font-size:14px;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                    ${item.name}
                                </div>
                                <div style="font-size:12px;color:#717fe0;margin-top:2px">${item.price} FCFA</div>
                            </div>
                        </a>`;
                });

                // Lien "Voir tous les résultats"
                html += `
                    <a href="{{ route('client.search') }}?q=${encodeURIComponent(q)}"
                       style="display:block;text-align:center;padding:10px;font-size:13px;
                              color:#717fe0;border-top:1px solid #f0f0f0;text-decoration:none;
                              font-weight:600">
                        Voir tous les résultats →
                    </a>`;

                $suggestions.html(html).show();
            });
        }, 300);
    });

    // Hover effect suggestions
    $suggestions.on('mouseenter', '.search-suggest-item', function () {
        $(this).css('background', '#f9f9f9');
    }).on('mouseleave', '.search-suggest-item', function () {
        $(this).css('background', '#fff');
    });

    // Fermer les suggestions en cliquant ailleurs
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#search-suggestions, .wrap-search-header').length) {
            $suggestions.hide();
        }
    });

    // Naviguer dans les suggestions avec ↑↓ + Entrée
    $searchInput.on('keydown', function (e) {
        const $items = $suggestions.find('a');
        const $active = $items.filter('.suggest-active');

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            $items.removeClass('suggest-active').css('background', '');
            const $next = $active.length ? $active.next('a') : $items.first();
            $next.addClass('suggest-active').css('background', '#f0f4ff');
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            $items.removeClass('suggest-active').css('background', '');
            const $prev = $active.length ? $active.prev('a') : $items.last();
            $prev.addClass('suggest-active').css('background', '#f0f4ff');
        } else if (e.key === 'Enter' && $active.length) {
            e.preventDefault();
            window.location.href = $active.attr('href');
        } else if (e.key === 'Escape') {
            $suggestions.hide();
        }
    });

    // ================================================================
    // 4. HANDLER D'ERREUR AJAX CENTRALISÉ
    // ================================================================
    
    function handleAjaxError(xhr) {
        if (xhr.status === 401 && xhr.responseJSON?.redirect) {
            window.location.href = xhr.responseJSON.redirect;
        } else {
            const msg = xhr.responseJSON?.message || 'Une erreur est survenue.';
            toastr.error(msg, 'Erreur');
        }
    }

    // Exposer globalement pour les autres scripts (cart sidebar, etc.)
    window.handleAjaxError = handleAjaxError;
    window.requireAuth     = requireAuth;
});
</script>

<script>
    $(document).ready(function () {
    // ─── INITIALISATION D'ISOTOPE ───────────────────────────────
    var $grid = $('.isotope-grid').isotope({
        itemSelector: '.isotope-item',
        layoutMode: 'fitRows',
        percentPosition: true,
        getSortData: {
            price: function(itemElem) {
                // Récupérer le prix correctement (géré avec la promo)
                var priceText = $(itemElem).find('.stext-105').first().text().trim();
                // Si c'est un prix avec espace (ex: "125 000 FCFA"), remplacer les espaces
                priceText = priceText.replace(/\s/g, '').replace('FCFA', '');
                return parseFloat(priceText) || 0;
            },
            name: function(itemElem) {
                return $(itemElem).find('.js-name-b2').text().toLowerCase();
            }
        }
    });

    // ─── VARIABLES GLOBALES ─────────────────────────────────────
    var currentSearch = '';
    var currentSort = 'default';
    var currentPrice = 'all';
    var currentBrand = 'all';
    var currentColor = 'all';
    var currentCategory = 'all'; // AJOUT : pour les catégories du panel
    var currentFilter = '*';      // pour les boutons du haut

    // ─── FONCTION DE FILTRAGE COMBINÉ ───────────────────────────
    function passesFilters($item) {
        var name = $item.find('.js-name-b2').text().toLowerCase();
        var price = getPrice($item);
        var brandId = $item.data('brand-id') || '';
        
        // 🔥 FILTRE CATÉGORIE (boutons du haut)
        var topCatMatch = true;
        if (currentFilter !== '*') {
            var catClass = currentFilter.replace('.', '');
            topCatMatch = $item.hasClass(catClass);
        }
        
        // 🔥 FILTRE CATÉGORIE (panel latéral)
        var panelCatMatch = true;
        if (currentCategory !== 'all') {
            panelCatMatch = $item.hasClass('cat-' + currentCategory);
        }
        
        // Filtre recherche
        var searchMatch = (currentSearch === '') || name.includes(currentSearch.toLowerCase());
        
        // Filtre prix
        var priceMatch = true;
        if (currentPrice !== 'all') {
            if (currentPrice === '500000+') {
                priceMatch = price >= 500000;
            } else {
                var parts = currentPrice.split('-');
                priceMatch = price >= parseInt(parts[0]) && price <= parseInt(parts[1]);
            }
        }
        
        // Filtre couleur
        var colorMatch = true;
        if (currentColor !== 'all') {
            var productColors = $item.data('colors') || [];
            if (typeof productColors === 'string') {
                try { productColors = JSON.parse(productColors); } catch(e) { productColors = []; }
            }
            colorMatch = productColors.some(function(c) { return c.id == currentColor; });
        }
        
        // Filtre marque
        var brandMatch = (currentBrand === 'all') || (brandId == currentBrand);
        
        // COMBINAISON : les deux catégories doivent matcher
        return topCatMatch && panelCatMatch && searchMatch && priceMatch && colorMatch && brandMatch;
    }

    // ─── FILTRES DU HAUT (CATÉGORIES) ───────────────────────────
    $('.filter-tope-group button').on('click', function() {
        $('.filter-tope-group button').removeClass('how-active1');
        $(this).addClass('how-active1');
        
        currentFilter = $(this).attr('data-filter');
        
        // Appliquer le filtre Isotope
        $grid.isotope({ 
            filter: function() {
                return passesFilters($(this));
            }
        });
    });

    // ─── FILTRE CATÉGORIE (PANEL LATÉRAL) ───────────────────────
    // ✅ CORRECTION : Cette partie ne fonctionnait pas avant
    $('.filter-link[data-category]').on('click', function(e) {
        e.preventDefault();
        
        // Retirer la classe active de tous les liens de catégorie
        $('.filter-link[data-category]').removeClass('filter-link-active');
        
        // Ajouter la classe active sur l'élément cliqué
        $(this).addClass('filter-link-active');
        
        // Récupérer l'ID de la catégorie
        currentCategory = $(this).data('category');
        
        console.log('Catégorie sélectionnée (panel):', currentCategory); // Debug
        
        // Appliquer le filtre
        $grid.isotope({ 
            filter: function() {
                return passesFilters($(this));
            }
        });
    });

    // ─── FILTRE RECHERCHE ───────────────────────────────────────
    $('#search-product').on('keyup', function() {
        currentSearch = $(this).val();
        $grid.isotope({ 
            filter: function() {
                return passesFilters($(this));
            }
        });
    });

    // ─── FILTRE COULEUR ─────────────────────────────────────────
    $('.filter-color-link').on('click', function(e) {
        e.preventDefault();
        $('.filter-color-link').css('border', '2px solid transparent');
        $(this).css('border', '2px solid #333');
        currentColor = $(this).data('color');
        $grid.isotope({ 
            filter: function() {
                return passesFilters($(this));
            }
        });
    });

    // ─── FILTRE PRIX ────────────────────────────────────────────
    $('.filter-link[data-price]').on('click', function(e) {
        e.preventDefault();
        $('.filter-link[data-price]').removeClass('filter-link-active');
        $(this).addClass('filter-link-active');
        currentPrice = $(this).data('price');
        $grid.isotope({ 
            filter: function() {
                return passesFilters($(this));
            }
        });
    });

    // ─── FILTRE MARQUE ──────────────────────────────────────────
    $('[data-brand]').on('click', function(e) {
        e.preventDefault();
        $('[data-brand]').removeClass('active-brand');
        $(this).toggleClass('active-brand');
        currentBrand = $(this).hasClass('active-brand') ? $(this).data('brand') : 'all';
        $grid.isotope({ 
            filter: function() {
                return passesFilters($(this));
            }
        });
    });

    // ─── TRI ────────────────────────────────────────────────────
    $('.filter-link[data-sort]').on('click', function(e) {
        e.preventDefault();
        $('.filter-link[data-sort]').removeClass('filter-link-active');
        $(this).addClass('filter-link-active');
        currentSort = $(this).data('sort');
        
        var sortValue = 'original-order';
        if (currentSort === 'price-asc') {
            sortValue = 'price';
        } else if (currentSort === 'price-desc') {
            sortValue = 'price desc';
        }
        
        $grid.isotope({ 
            sortBy: sortValue,
            filter: function() {
                return passesFilters($(this));
            }
        });
    });

    // ─── FONCTION POUR EXTRAIRE LE PRIX ─────────────────────────
    function getPrice($item) {
        var priceElement = $item.find('.stext-105').first();
        var priceText = priceElement.text().trim();
        
        // Enlever "FCFA" et les espaces
        priceText = priceText.replace('FCFA', '').replace(/\s/g, '');
        
        // Si c'est un prix barré (promo), prendre le prix en promo
        var promoPrice = $item.find('.text-danger').first().text().trim();
        if (promoPrice) {
            promoPrice = promoPrice.replace('FCFA', '').replace(/\s/g, '');
            return parseFloat(promoPrice) || 0;
        }
        
        return parseFloat(priceText) || 0;
    }

    // ─── MESSAGE AUCUN RÉSULTAT ─────────────────────────────────
    $grid.on('arrangeComplete', function(event, filteredItems) {
        var $noResult = $grid.find('.no-result-msg');
        if (filteredItems.length === 0) {
            if ($noResult.length === 0) {
                $grid.append(`
                    <div class="no-result-msg col-12 text-center p-t-50 p-b-50">
                        <i class="zmdi zmdi-search" style="font-size:40px;color:#ddd;display:block;margin-bottom:12px"></i>
                        <p class="stext-113 cl6">Aucun produit ne correspond à votre sélection.</p>
                    </div>
                `);
            }
        } else {
            $noResult.remove();
        }
    });

    // ─── ACTIVER LE FILTRE CATÉGORIE DEPUIS L'URL ───────────────
    var urlParams = new URLSearchParams(window.location.search);
    var categoryParam = urlParams.get('category');
    
    if (categoryParam) {
        // Activer le bouton du haut
        $('.filter-tope-group button').removeClass('how-active1');
        var $catButton = $('.filter-tope-group button[data-filter=".cat-' + categoryParam + '"]');
        $catButton.addClass('how-active1');
        currentFilter = '.cat-' + categoryParam;
        
        // Appliquer le filtre
        $grid.isotope({ 
            filter: function() {
                return passesFilters($(this));
            }
        });
    }

    // ─── DEBUG : Afficher les classes des produits ──────────────
    console.log('Classes des produits:');
    $('.isotope-item').each(function() {
        console.log($(this).attr('class'));
    });
});
</script>
{{-- Badge wishlist au chargement (côté serveur) --}}
@auth
<script>
    $(function () {
        const wishCount = {{ \App\Models\Wishlist::where('user_id', auth()->id())->count() }};
        if (wishCount > 0) {
            $('a[href="{{ route("client.wishlist") }}"].icon-header-noti').attr('data-notify', wishCount);
        }
    });
</script>
@endauth