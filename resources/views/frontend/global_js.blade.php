{{--
    ════════════════════════════════════════════════════════
    GLOBAL JS — ABS TECHNOLOGIE
    Correction : bouton "Ajouter" sur les cards produits
    - Si le produit a des couleurs → ouvre le modal quick view
    - Sinon → ajoute directement au panier via AJAX
    ════════════════════════════════════════════════════════
--}}

<!-- Toastr -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> --}}
<script>
    // ── ABS Notif (remplace Toastr) ──
(function() {
  const ICONS = {
    success: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>`,
    error:   `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>`,
    warning: `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`,
    info:    `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`
  };

  function getContainer() {
    let c = document.getElementById('abs-notif-container');
    if (!c) { c = document.createElement('div'); c.id = 'abs-notif-container'; document.body.appendChild(c); }
    return c;
  }

  function show(type, message, title, duration) {
    duration = duration || 3800;
    const el = document.createElement('div');
    el.className = `abs-notif t-${type}`;
    el.innerHTML = `
      <div class="abs-notif-icon">${ICONS[type]}</div>
      <div class="abs-notif-body">
        ${title ? `<p class="abs-notif-title">${title}</p>` : ''}
        ${message ? `<p class="abs-notif-msg">${message}</p>` : ''}
      </div>
      <button class="abs-notif-close" aria-label="Fermer">✕</button>
      <div class="abs-notif-bar" style="animation-duration:${duration}ms"></div>`;
    el.querySelector('.abs-notif-close').addEventListener('click', () => dismiss(el));
    getContainer().appendChild(el);
    el._timer = setTimeout(() => dismiss(el), duration);
  }

  function dismiss(el) {
    clearTimeout(el._timer);
    el.classList.add('abs-hide');
    setTimeout(() => el.remove(), 240);
  }

  window.toastr = {
    success: (msg, title, opts) => show('success', msg, title, opts?.timeOut),
    error:   (msg, title, opts) => show('error',   msg, title, opts?.timeOut),
    warning: (msg, title, opts) => show('warning', msg, title, opts?.timeOut),
    info:    (msg, title, opts) => show('info',    msg, title, opts?.timeOut),
  };
})();
    </script>

    <script>
    /* ================================================================
    VARIABLES GLOBALES
    ================================================================ */
    const TOKEN = '{{ csrf_token() }}';
    const IS_AUTH = {{ auth()->check() ? 'true' : 'false' }};
    const LOGIN_URL = '{{ route("client.login") }}';

    function requireAuth(callback) {
        if (!IS_AUTH) { 
            window.location.href = LOGIN_URL + '?redirect=' + encodeURIComponent(window.location.pathname);
            return false; 
        }
        callback();
        return true;
    }
    window.requireAuth = requireAuth;

    function fmtPrice(n) { 
        return parseFloat(n).toLocaleString('fr-FR'); 
    }
    window.fmtPrice = fmtPrice;

    function updateHeaderBadge(count) {
        const $cartIcon = $('.js-show-cart');
        if (count > 0) {
            $cartIcon.attr('data-notify', count);
        } else {
            $cartIcon.removeAttr('data-notify');
        }
    }
    window.updateHeaderBadge = updateHeaderBadge;

    function handleAjaxError(xhr) {
        if (xhr.status === 401 && xhr.responseJSON?.redirect) {
            window.location.href = xhr.responseJSON.redirect;
        } else {
            toastr.error(xhr.responseJSON?.message || 'Une erreur est survenue.', 'Erreur');
        }
    }
    window.handleAjaxError = handleAjaxError;

    /* ================================================================
    BOUTON "AJOUTER" SUR LES CARDS PRODUITS
    ================================================================ */
    /* ================================================================
   BOUTON "AJOUTER" SUR LES CARDS PRODUITS
   - Vérifie si le produit a des couleurs
   - Si oui → ouvre le modal quick view pour choisir la couleur
   - Si non → ajoute directement au panier
   ================================================================ */
    $(document).ready(function () {
        $(document).on('click', '.abs-add-to-cart', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if (!IS_AUTH) {
                toastr.warning('Veuillez vous connecter pour ajouter des articles au panier.', 'Connexion requise');
                setTimeout(() => {
                    window.location.href = LOGIN_URL + '?redirect=' + encodeURIComponent(window.location.pathname);
                }, 1500);
                return;
            }

            const $btn = $(this);
            const productId = $btn.data('product-id');
            const productName = $btn.data('product-name');
            
            if (!productId) return;

            // Feedback visuel de chargement
            const originalHtml = $btn.html();
            $btn.html('<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation: spin 0.6s linear infinite"><path d="M21 12a9 9 0 11-6.2-8.56"/></svg>').prop('disabled', true);

            // Vérifier si le produit a des couleurs
            $.ajax({
                url: '/client/products/' + productId,
                method: 'GET',
                success: function(response) {
                    const p = response.product || response;
                    
                    if (!p) {
                        // Fallback : ajout direct
                        addToCartDirect(productId, $btn, originalHtml);
                        return;
                    }

                    const hasColors = p.colors && p.colors.length > 0;
                    const hasMultipleColors = hasColors && p.colors.filter(c => (c.pivot ? c.pivot.stock_quantity : 0) > 0).length > 1;

                    if (hasColors && hasMultipleColors) {
                        // Le produit a plusieurs couleurs → ouvrir le modal
                        $btn.html(originalHtml).prop('disabled', false);
                        openQuickViewModal(productId, p);
                        toastr.info(
                            'Ce produit est disponible en plusieurs couleurs. Veuillez en choisir une.',
                            'Choisissez une couleur',
                            { timeOut: 3000 }
                        );
                    } else if (hasColors && p.colors.filter(c => (c.pivot ? c.pivot.stock_quantity : 0) > 0).length === 1) {
                        // Une seule couleur disponible → ajouter directement avec cette couleur
                        const availableColor = p.colors.find(c => (c.pivot ? c.pivot.stock_quantity : 0) > 0);
                        addToCartWithColor(productId, availableColor.id, $btn, originalHtml);
                    } else {
                        // Pas de couleur → ajout direct
                        addToCartDirect(productId, $btn, originalHtml);
                    }
                },
                error: function() {
                    // En cas d'erreur, essayer l'ajout direct
                    addToCartDirect(productId, $btn, originalHtml);
                }
            });
        });

        // Fonction d'ajout direct au panier (sans couleur)
        function addToCartDirect(productId, $btn, originalHtml) {
            $.ajax({
                url: '{{ route("client.cart.add") }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: 1,
                    _token: TOKEN
                },
                success: function(res) {
                    $btn.html('<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="13" height="13" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Ajouté !')
                        .css('background', '#22a05e');
                    setTimeout(() => {
                        $btn.html(originalHtml).css('background', '').prop('disabled', false);
                    }, 1500);
                    
                    toastr.success(res.message || 'Produit ajouté au panier.', 'Ajouté !');
                    if (res.cart_count !== undefined) updateHeaderBadge(res.cart_count);
                    if ($('.js-panel-cart').hasClass('show-header-cart')) loadSidebarCart();
                },
                error: function(xhr) {
                    $btn.html(originalHtml).prop('disabled', false);
                    if (xhr.status === 401) {
                        toastr.warning('Session expirée, veuillez vous reconnecter.', 'Session expirée');
                        setTimeout(() => window.location.href = LOGIN_URL, 1500);
                    } else {
                        toastr.error(xhr.responseJSON?.message || "Erreur lors de l'ajout.", 'Erreur');
                    }
                }
            });
        }

        // Fonction d'ajout avec une couleur spécifique
        function addToCartWithColor(productId, colorId, $btn, originalHtml) {
            $.ajax({
                url: '{{ route("client.cart.add") }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: 1,
                    color_id: colorId,
                    _token: TOKEN
                },
                success: function(res) {
                    $btn.html('<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="13" height="13" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Ajouté !')
                        .css('background', '#22a05e');
                    setTimeout(() => {
                        $btn.html(originalHtml).css('background', '').prop('disabled', false);
                    }, 1500);
                    
                    toastr.success(res.message || 'Produit ajouté au panier.', 'Ajouté !');
                    if (res.cart_count !== undefined) updateHeaderBadge(res.cart_count);
                    if ($('.js-panel-cart').hasClass('show-header-cart')) loadSidebarCart();
                },
                error: function(xhr) {
                    $btn.html(originalHtml).prop('disabled', false);
                    toastr.error(xhr.responseJSON?.message || "Erreur lors de l'ajout.", 'Erreur');
                }
            });
        }

        // Fonction d'ouverture du modal quick view
        function openQuickViewModal(productId, productData) {
            // Chercher un bouton .js-show-modal1 existant
            const $trigger = $(`.js-show-modal1[data-product-id="${productId}"]`).first();
            
            if ($trigger.length) {
                $trigger.trigger('click');
                return;
            }
            
            // Fallback : ouvrir le modal manuellement
            const $modal = $('.js-modal1');
            $modal.addClass('show-modal1');
            $('#modal1-loader').show();
            $('#modal1-content').hide();
            
            // Remplir le modal avec les données déjà chargées
            setTimeout(function() {
                if (typeof fillModal === 'function') {
                    fillModal(productData);
                } else {
                    // Recharger les données
                    $.ajax({
                        url: '/client/products/' + productId,
                        method: 'GET',
                        success: function(res) {
                            const p = res.product || res;
                            if (typeof fillModal === 'function') {
                                fillModal(p);
                            }
                        }
                    });
                }
            }, 50);
        }

        // Animation spin
        if (!document.getElementById('spin-style')) {
            $('<style>@keyframes spin { to { transform: rotate(360deg); } }</style>').appendTo('head');
        }
    });

    /* ================================================================
    QUICK VIEW MODAL
    ================================================================ */
    $(document).ready(function () {
        let currentProductId = null;
        let selectedColorId = null;

        // Ouverture du modal
        $(document).on('click', '.js-show-modal1, .ps-quickview', function (e) {
            e.preventDefault();
            const productId = $(this).data('product-id');
            if (!productId) return;
            
            selectedColorId = null;
            currentProductId = productId;
            
            $('.js-modal1').addClass('show-modal1');
            $('#modal1-loader').show();
            $('#modal1-content').hide();
            
            $.ajax({
                url: '/client/products/' + productId,
                method: 'GET',
                success: function(response) {
                    const p = response.product || response;
                    if (!p) {
                        showModalError('Produit introuvable.');
                        return;
                    }
                    fillModal(p);
                },
                error: function() {
                    showModalError('Impossible de charger ce produit.');
                }
            });
        });
        
        // Fermeture
        $(document).on('click', '.js-hide-modal1, .overlay-modal1', function () {
            $('.js-modal1').removeClass('show-modal1');
        });
        
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') $('.js-modal1').removeClass('show-modal1');
        });
        
        // Remplissage du modal
        function fillModal(p) {
            $('#modal1-loader').hide();
            $('#modal1-content').show();
            
            // Badges
            let badges = '';
            if (p.is_featured) badges += '<span class="modal1-badge modal1-badge-featured">⭐ Coup de cœur</span>';
            if (isNew(p.created_at)) badges += '<span class="modal1-badge modal1-badge-new">Nouveau</span>';
            $('#modal1-badges').html(badges);
            
            // Nom
            $('#modal1-name').text(p.name);
            
            // Prix
            let priceHtml = '';
            if (p.compare_price && parseFloat(p.compare_price) > parseFloat(p.price)) {
                const pct = Math.round((1 - p.price / p.compare_price) * 100);
                priceHtml = `
                    <span class="modal1-price-old">${fmtNumber(p.compare_price)} FCFA</span>
                    <span class="modal1-price-main">${fmtNumber(p.price)} FCFA</span>
                    <span class="modal1-discount">−${pct}%</span>`;
            } else {
                priceHtml = `<span class="modal1-price-main">${fmtNumber(p.price)} FCFA</span>`;
            }
            $('#modal1-price').html(priceHtml);
            
            // Méta
            let metaHtml = '';
            if (p.category) metaHtml += `<span class="modal1-meta-item"><strong>Catégorie :</strong> ${p.category.name}</span>`;
            if (p.brand) metaHtml += `<span class="modal1-meta-item"><strong>Marque :</strong> ${p.brand.name}</span>`;
            $('#modal1-meta').html(metaHtml);
            
            // Description
            $('#modal1-desc').html(p.description || '<em>Aucune description disponible</em>');
            
            // Galerie
            buildSlick(p.images || []);
            
            // Couleurs
            if (p.colors && p.colors.length > 0) {
                let colorsHtml = '';
                p.colors.forEach(function(c) {
                    const stock = c.pivot ? c.pivot.stock_quantity : 0;
                    const stockLabel = stock > 0 ? `(${stock})` : `<span style="color:#e65540">(épuisé)</span>`;
                    const disabled = stock === 0 ? 'disabled' : '';
                    colorsHtml += `
                        <button type="button" class="modal1-color-btn" data-color-id="${c.id}" data-stock="${stock}" ${disabled}>
                            <span class="modal1-color-dot" style="background:${c.code}"></span>
                            ${c.name} ${stockLabel}
                        </button>`;
                });
                $('#modal1-colors-list').html(colorsHtml);
                $('#modal1-colors-wrap').show();
                
                // Auto-sélection si une seule couleur disponible
                const available = p.colors.filter(c => (c.pivot ? c.pivot.stock_quantity : 0) > 0);
                if (available.length === 1) {
                    $(`.modal1-color-btn[data-color-id="${available[0].id}"]`).addClass('active');
                    selectedColorId = available[0].id;
                }
            } else {
                $('#modal1-colors-wrap').hide();
                selectedColorId = null;
            }
            
            // Spécifications
            if (p.specifications && p.specifications.length > 0) {
                let specsHtml = '';
                p.specifications.forEach(sp => {
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
            
            $('#modal1-add-cart').data('product-id', p.id).prop('disabled', false);
        }
        
        // Galerie Slick
        function buildSlick(images) {
            const $main = $('#modal1-slick');
            const $thumbs = $('#modal1-thumbs');
            
            if ($main.hasClass('slick-initialized')) $main.slick('unslick');
            if ($thumbs.hasClass('slick-initialized')) $thumbs.slick('unslick');
            $main.html('');
            $thumbs.html('');
            
            if (images.length === 0) {
                $main.html(`
                    <div class="item-slick3">
                        <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:380px;color:#ccc">
                            <i class="zmdi zmdi-image-alt" style="font-size:56px"></i>
                            <p style="font-size:13px;margin-top:12px">Aucune image disponible</p>
                        </div>
                    </div>`);
                setTimeout(() => {
                    if (typeof $.fn.slick !== 'undefined') {
                        $main.slick({ slidesToShow: 1, slidesToScroll: 1, arrows: false, dots: false });
                    }
                }, 80);
                return;
            }
            
            let mainHtml = '', thumbsHtml = '';
            images.forEach((img, i) => {
                const src = '/storage/' + (img.image_path || img);
                mainHtml += `
                    <div class="item-slick3">
                        <div class="wrap-pic-w pos-relative">
                            <img src="${src}" alt="Image produit" style="width:100%;height:380px;object-fit:contain;display:block;">
                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="${src}">
                                <i class="fa fa-expand"></i>
                            </a>
                        </div>
                    </div>`;
                thumbsHtml += `
                    <div class="modal1-thumb-item ${i === 0 ? 'active' : ''}" data-index="${i}" style="border-color:${i === 0 ? '#717fe0' : '#e0e8f4'}">
                        <img src="${src}" alt="thumb" style="width:100%;height:100%;object-fit:cover;">
                    </div>`;
            });
            
            $main.html(mainHtml);
            $thumbs.html(thumbsHtml);
            
            setTimeout(() => {
                if (typeof $.fn.slick === 'undefined') {
                    console.error('Slick carousel not loaded');
                    return;
                }
                
                $main.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    fade: true,
                    arrows: true,
                    dots: false,
                    prevArrow: '<button class="arrow-slick3 prev-slick3"><i class="fa fa-angle-left"></i></button>',
                    nextArrow: '<button class="arrow-slick3 next-slick3"><i class="fa fa-angle-right"></i></button>'
                });
                
                // Click sur thumbnails
                $('.modal1-thumb-item').off('click').on('click', function() {
                    const idx = parseInt($(this).data('index'));
                    $('.modal1-thumb-item').css('border-color', '#e0e8f4');
                    $(this).css('border-color', '#717fe0');
                    $main.slick('slickGoTo', idx);
                });
                
                // Sync main -> thumbs
                $main.off('afterChange').on('afterChange', function(e, slick, cur) {
                    $('.modal1-thumb-item').css('border-color', '#e0e8f4');
                    $(`.modal1-thumb-item[data-index="${cur}"]`).css('border-color', '#717fe0');
                });
                
                // Magnific Popup
                if (typeof $.fn.magnificPopup !== 'undefined') {
                    $main.magnificPopup({
                        delegate: 'a',
                        type: 'image',
                        gallery: { enabled: true },
                        mainClass: 'mfp-fade'
                    });
                }
            }, 100);
        }
        
        // Sélection couleur
        $(document).on('click', '.modal1-color-btn', function() {
            if ($(this).prop('disabled')) return;
            $('.modal1-color-btn').removeClass('active');
            $(this).addClass('active');
            selectedColorId = $(this).data('color-id');
        });
        
        // Quantité
        $(document).on('click', '#modal1-qty-up', function() {
            const $q = $('#modal1-qty');
            $q.val(parseInt($q.val() || 1) + 1);
        });
        
        $(document).on('click', '#modal1-qty-down', function() {
            const $q = $('#modal1-qty');
            const v = parseInt($q.val() || 1);
            if (v > 1) $q.val(v - 1);
        });
        
        // Ajout au panier depuis modal
        $(document).on('click', '#modal1-add-cart', function() {
            if (!IS_AUTH) {
                toastr.warning('Veuillez vous connecter.', 'Connexion requise');
                setTimeout(() => window.location.href = LOGIN_URL, 1500);
                return;
            }
            
            const productId = $(this).data('product-id');
            const qty = parseInt($('#modal1-qty').val()) || 1;
            
            if ($('#modal1-colors-wrap').is(':visible') && !selectedColorId) {
                toastr.warning('Veuillez choisir une couleur.', 'Couleur requise');
                return;
            }
            
            const $btn = $(this);
            const originalText = $btn.html();
            $btn.html('Ajout en cours...').prop('disabled', true);
            
            $.ajax({
                url: '{{ route("client.cart.add") }}',
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: qty,
                    color_id: selectedColorId || '',
                    _token: TOKEN
                },
                success: function(res) {
                    $btn.html(originalText).prop('disabled', false);
                    toastr.success(res.message || 'Produit ajouté au panier.', 'Ajouté !');
                    if (res.cart_count !== undefined) updateHeaderBadge(res.cart_count);
                    if ($('.js-panel-cart').hasClass('show-header-cart')) loadSidebarCart();
                    $('.js-modal1').removeClass('show-modal1');
                },
                error: function(xhr) {
                    $btn.html(originalText).prop('disabled', false);
                    toastr.error(xhr.responseJSON?.message || "Erreur lors de l'ajout.", 'Erreur');
                }
            });
        });
        
        // Utilitaires
        function resetModal() {
            currentProductId = null;
            selectedColorId = null;
            $('#modal1-badges,#modal1-name,#modal1-price,#modal1-meta,#modal1-desc,#modal1-colors-list,#modal1-specs-list').html('');
            $('#modal1-colors-wrap,#modal1-specs-wrap').hide();
            $('#modal1-qty').val(1);
            const $s = $('#modal1-slick');
            if ($s.hasClass('slick-initialized')) $s.slick('unslick');
            $s.html('');
            $('#modal1-thumbs').html('');
        }
        
        function showModalError(msg) {
            $('#modal1-loader').hide();
            $('#modal1-content').show();
            $('#modal1-name').text('Erreur');
            $('#modal1-desc').html(`<span style="color:#e65540">${msg}</span>`);
        }
        
        function fmtNumber(n) {
            return parseFloat(n).toLocaleString('fr-FR');
        }
        
        function isNew(d) {
            return d && (Date.now() - new Date(d).getTime()) / 86400000 <= 30;
        }
    });

    /* ================================================================
    SIDEBAR PANIER
    ================================================================ */
    $(document).ready(function () {
        window.loadSidebarCart = function() {
            const $list = $('#sidebar-cart-items');
            $list.html('<li style="text-align:center;padding:40px 0"><i class="zmdi zmdi-rotate-right zmdi-hc-spin" style="font-size:24px"></i><br><small>Chargement...</small></li>');
            
            $.ajax({
                url: '{{ route("client.cart.sidebar") }}',
                method: 'GET',
                success: function(res) {
                    renderSidebarCart(res.items, res.total, res.count);
                },
                error: function() {
                    $list.html('<li style="text-align:center;padding:20px;color:#999">Erreur de chargement.</li>');
                }
            });
        };
        
        function renderSidebarCart(items, total, count) {
            const $list = $('#sidebar-cart-items');
            const $footer = $('#sidebar-cart-footer');
            
            $list.html('');
            
            if (!items || !items.length) {
                $list.html(`
                    <li style="text-align:center;padding:60px 20px">
                        <div style="width:80px;height:80px;background:#f8f9fa;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px">
                            <i class="zmdi zmdi-shopping-cart" style="font-size:40px;color:#ddd"></i>
                        </div>
                        <p style="color:#999;margin-bottom:20px">Votre panier est vide.</p>
                        <a href="{{ route('client.product') }}" style="display:inline-block;padding:10px 24px;background:#717fe0;color:#fff;border-radius:40px;text-decoration:none">Découvrir nos produits</a>
                    </li>`);
                if ($footer) $footer.hide();
                updateHeaderBadge(0);
                return;
            }
            
            if ($footer) $footer.show();
            
            items.forEach(item => {
                const imgSrc = item.image ? '/storage/' + item.image : '/frontend/images/no-image.jpg';
                const colorHtml = item.color ? 
                    `<span class="sidebar-color-dot" style="background:${item.color.code}"></span>${item.color.name} · ` : '';
                
                $list.append(`
                    <li class="header-cart-item" data-item-id="${item.id}" style="display:flex;align-items:center;gap:15px;padding:15px 0;border-bottom:1px solid #f5f5f5">
                        <div class="header-cart-item-img">
                            <img src="${imgSrc}" alt="${item.name}" style="width:70px;height:70px;object-fit:cover;border-radius:8px">
                        </div>
                        <div style="flex:1;min-width:0">
                            <a href="/client/product/detail/${item.product_id}" class="header-cart-item-name" style="font-size:14px;font-weight:600;color:#333;text-decoration:none;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${item.name}</a>
                            <span style="font-size:12px;color:#666">${colorHtml}${item.quantity} × ${fmtPrice(item.price)} FCFA</span>
                        </div>
                        <button type="button" class="sidebar-cart-remove" data-item-id="${item.id}" style="background:none;border:none;color:#ccc;cursor:pointer;padding:8px;border-radius:50%">✕</button>
                    </li>`);
            });
            
            $('#sidebar-cart-total').text(fmtPrice(total) + ' FCFA');
            updateHeaderBadge(count);
        }
        
        $(document).on('click', '.js-show-cart', function(e) {
            e.preventDefault();
            loadSidebarCart();
        });
        
        $(document).on('click', '.sidebar-cart-remove', function() {
            const itemId = $(this).data('item-id');
            const $li = $(this).closest('li');
            $li.css('opacity', 0.4);
            
            $.ajax({
                url: '{{ route("client.cart.remove") }}',
                method: 'POST',
                data: { item_id: itemId, _token: TOKEN },
                success: function() {
                    $li.fadeOut(250, function() { 
                        $(this).remove(); 
                        loadSidebarCart(); 
                    });
                },
                error: function() {
                    $li.css('opacity', 1);
                    toastr.error('Impossible de supprimer cet article.', 'Erreur');
                }
            });
        });
    });

    /* ================================================================
    WISHLIST
    ================================================================ */
    $(document).ready(function () {
        if (IS_AUTH) {
            $.getJSON('{{ route("client.wishlist.ids") }}', function(res) {
                (res.ids || []).forEach(pid => {
                    $(`.js-addwish-b2[data-product-id="${pid}"]`).addClass('js-addedwish-b2');
                });
            });
        }
        
        $(document).on('click', '.js-addwish-b2', function(e) {
            e.preventDefault();
            const $btn = $(this);
            const productId = $btn.data('product-id');
            if (!productId) return;
            
            requireAuth(function() {
                $.ajax({
                    url: '{{ route("client.wishlist.toggle") }}',
                    method: 'POST',
                    data: { product_id: productId, _token: TOKEN },
                    success: function(res) {
                        if (res.status === 'added') {
                            $btn.addClass('js-addedwish-b2');
                            toastr.success('Produit ajouté aux favoris !', 'Favoris');
                        } else {
                            $btn.removeClass('js-addedwish-b2');
                            toastr.info('Produit retiré des favoris.', 'Favoris');
                        }
                        $('a[href="{{ route("client.wishlist") }}"].icon-header-noti').attr('data-notify', res.count > 0 ? res.count : '');
                    },
                    error: handleAjaxError
                });
            });
        });
    });
    /* ================================================================
    RECHERCHE AUTOCOMPLETE
    ================================================================ */
    $(document).ready(function () {
        let searchTimer = null;
        const $searchInput = $('input[name="q"].plh3');
        $searchInput.closest('form').css('position', 'relative');

        const $suggestions = $('<div id="search-suggestions"></div>').css({
            position: 'absolute', top: '100%', left: 0, right: 0,
            background: '#fff', border: '1px solid #e6e6e6', borderTop: 'none',
            zIndex: 9999, maxHeight: '360px', overflowY: 'auto',
            boxShadow: '0 8px 24px rgba(0,0,0,.1)',
            borderRadius: '0 0 8px 8px', display: 'none',
        }).insertAfter($searchInput);

        $searchInput.on('input', function () {
            clearTimeout(searchTimer);
            const q = $(this).val().trim();
            if (q.length < 2) { $suggestions.hide().html(''); return; }
            searchTimer = setTimeout(function () {
                $.getJSON('{{ route("client.search.suggest") }}', { q }, function (results) {
                    if (!results.length) { $suggestions.hide().html(''); return; }
                    let html = '';
                    results.forEach(item => {
                        html += `
                            <a href="${item.url}" class="search-suggest-item"
                            style="display:flex;align-items:center;gap:12px;padding:10px 16px;
                                    text-decoration:none;color:#333;
                                    border-bottom:1px solid #f5f5f5;transition:background .15s">
                                <img src="${item.image}" alt="${item.name}"
                                    style="width:44px;height:44px;object-fit:cover;border-radius:6px;flex-shrink:0">
                                <div style="flex:1;min-width:0">
                                    <div style="font-size:14px;font-weight:500;
                                                white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                        ${item.name}
                                    </div>
                                    <div style="font-size:12px;color:#0066CC;margin-top:2px">
                                        ${item.price} FCFA
                                    </div>
                                </div>
                            </a>`;
                    });
                    html += `
                        <a href="{{ route('client.search') }}?q=${encodeURIComponent(q)}"
                        style="display:block;text-align:center;padding:10px;font-size:13px;
                                color:#0066CC;border-top:1px solid #f0f0f0;
                                text-decoration:none;font-weight:600">
                            Voir tous les résultats →
                        </a>`;
                    $suggestions.html(html).show();
                });
            }, 300);
        });

        $suggestions
            .on('mouseenter', '.search-suggest-item', function () { $(this).css('background', '#f9f9f9'); })
            .on('mouseleave', '.search-suggest-item', function () { $(this).css('background', '#fff'); });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('#search-suggestions, .wrap-search-header').length)
                $suggestions.hide();
        });

        $searchInput.on('keydown', function (e) {
            const $items  = $suggestions.find('a');
            const $active = $items.filter('.suggest-active');
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                $items.removeClass('suggest-active').css('background', '');
                ($active.length ? $active.next('a') : $items.first()).addClass('suggest-active').css('background', '#f0f4ff');
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                $items.removeClass('suggest-active').css('background', '');
                ($active.length ? $active.prev('a') : $items.last()).addClass('suggest-active').css('background', '#f0f4ff');
            } else if (e.key === 'Enter' && $active.length) {
                e.preventDefault();
                window.location.href = $active.attr('href');
            } else if (e.key === 'Escape') {
                $suggestions.hide();
            }
        });
    });

    /* ================================================================
    FILTRES PRODUITS
    ================================================================ */
    $(document).ready(function () {
        var filters = {
            category : '{{ request("category") ?? "all" }}',
            brand    : 'all',
            color    : 'all',
            price    : 'all',
            search   : '',
            sort     : 'default',
            page     : 1,
        };
        var isLoading = false;

        function fetchProducts(append) {
            append = append || false;
            if (isLoading) return;
            isLoading = true;

            const $grid    = $('#psGrid');
            const $loadBtn = $('#load-more');

            if (!append) {
                filters.page = 1;
                // Spinner pendant le chargement
                $grid.html('<div style="grid-column:1/-1;text-align:center;padding:60px 0"><i class="zmdi zmdi-rotate-right zmdi-hc-spin" style="font-size:32px;color:#717fe0"></i></div>');
                $('.ps-view-all').hide();
            } else {
                $loadBtn.html('Chargement...');
                $loadBtn.css('pointer-events','none');
            }

            $.ajax({
                url    : '{{ route("client.product") }}',
                method : 'GET',
                headers: { 'X-Requested-With':'XMLHttpRequest', 'Accept':'application/json' },
                data   : {
                    category : filters.category !== 'all'     ? filters.category : undefined,
                    brand    : filters.brand    !== 'all'     ? filters.brand    : undefined,
                    color    : filters.color    !== 'all'     ? filters.color    : undefined,
                    price    : filters.price    !== 'all'     ? filters.price    : undefined,
                    search   : filters.search   !== ''        ? filters.search   : undefined,
                    sort     : filters.sort     !== 'default' ? filters.sort     : undefined,
                    page     : filters.page,
                },
                success: function (res) {
                    if (append) {
                        // Ajouter les nouvelles cartes
                        const $newCards = $(res.html).filter('.ps-card');
                        $grid.append($newCards);
                    } else {
                        $grid.html(res.html);
                    }

                    if (res.has_more) {
                        filters.page = res.next_page;
                        $('.ps-view-all').show();
                        $loadBtn.html('Voir plus de produits <svg class="arrow" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>');
                        $loadBtn.css('pointer-events','');
                    } else {
                        $('.ps-view-all').hide();
                    }
                },
                error: function () {
                    if (!append) $grid.html('<div style="grid-column:1/-1;text-align:center;padding:60px 0;color:#999">Erreur de chargement.</div>');
                    toastr.error('Impossible de charger les produits.','Erreur');
                    $loadBtn.html('Voir plus de produits').css('pointer-events','');
                },
                complete: function () { isLoading = false; }
            });
        }

        // ── Load more ──
        $(document).on('click', '#load-more', function (e) {
            e.preventDefault();
            if (!isLoading) fetchProducts(true);
        });

        // ── Filtres catégories (boutons .ps-filter-btn) ──
        $(document).on('click', '.ps-filter-btn', function () {
            $('.ps-filter-btn').removeClass('active');
            $(this).addClass('active');
            const f = $(this).data('filter');
            filters.category = (f === 'all') ? 'all' : f.replace('cat-','');
            fetchProducts();
        });

        // ── Filtre par marque ──
        $(document).on('click', '[data-brand]', function (e) {
            e.preventDefault();
            $('[data-brand]').removeClass('active-brand');
            $(this).toggleClass('active-brand');
            filters.brand = $(this).hasClass('active-brand') ? $(this).data('brand') : 'all';
            fetchProducts();
        });

        // ── Filtre par couleur ──
        $(document).on('click', '.filter-color-link', function (e) {
            e.preventDefault();
            $('.filter-color-link').css('border','2px solid transparent');
            $(this).css('border','2px solid #333');
            filters.color = $(this).data('color');
            fetchProducts();
        });

        // ── Filtre par prix ──
        $(document).on('click', '.filter-link[data-price]', function (e) {
            e.preventDefault();
            $('.filter-link[data-price]').removeClass('filter-link-active');
            $(this).addClass('filter-link-active');
            filters.price = $(this).data('price');
            fetchProducts();
        });

        // ── Tri ──
        $(document).on('click', '.filter-link[data-sort]', function (e) {
            e.preventDefault();
            $('.filter-link[data-sort]').removeClass('filter-link-active');
            $(this).addClass('filter-link-active');
            filters.sort = $(this).data('sort');
            fetchProducts();
        });

        // ── Recherche live ──
        var searchTimer2 = null;
        $(document).on('keyup', '#search-product', function () {
            clearTimeout(searchTimer2);
            var q = $(this).val().trim();
            searchTimer2 = setTimeout(function () { filters.search = q; fetchProducts(); }, 400);
        });

        // ── URL param category au chargement ──
        var urlParams = new URLSearchParams(window.location.search);
        var categoryParam = urlParams.get('category');
        if (categoryParam) {
            filters.category = categoryParam;
            $('.ps-filter-btn[data-filter="cat-'+categoryParam+'"]').addClass('active')
                .siblings().removeClass('active');
        }

        // ── Bouton "Ajouter" dans les cartes (ps-add-btn) ──
        // $(document).on('click', '.abs-add-to-cart', function (e) {
        //     e.preventDefault(); e.stopPropagation();
        //     if (!IS_AUTH) {
        //         toastr.warning('Veuillez vous connecter pour ajouter des articles au panier.','Connexion requise');
        //         setTimeout(() => window.location.href = LOGIN_URL + '?redirect=' + encodeURIComponent(window.location.pathname), 1500);
        //         return;
        //     }
        //     const productId = $(this).data('product-id');
        //     const $btn = $(this), orig = $btn.html();
        //     $btn.html('<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="13" height="13" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Ajouté !').css('background','#22a05e');
        //     setTimeout(() => { $btn.html(orig).css('background',''); }, 1500);

        //     $.ajax({
        //         url   : '{{ route("client.cart.add") }}',
        //         method: 'POST',
        //         headers: { 'X-CSRF-TOKEN': TOKEN },
        //         contentType: 'application/json',
        //         data  : JSON.stringify({ product_id: productId, quantity: 1 }),
        //         success: function (res) {
        //             toastr.success(res.message || 'Produit ajouté au panier.','Ajouté !');
        //             if (res.cart_count !== undefined) updateHeaderBadge(res.cart_count);
        //         },
        //         error: handleAjaxError
        //     });
        // });
    });

    /* ================================================================
   BADGE WISHLIST AU CHARGEMENT
   ================================================================ */
    @auth
    $(function () {
        const wishCount = {{ \App\Models\Wishlist::where('user_id', auth()->id())->count() }};
        if (wishCount > 0) {
            $(`a[href="{{ route("client.wishlist") }}"].icon-header-noti`).attr('data-notify', wishCount);
        }
    });
    @endauth
</script>