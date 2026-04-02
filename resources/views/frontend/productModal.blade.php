{{-- ================================================================
     MODAL QUICK VIEW - DESIGN AMÉLIORÉ
     ================================================================ --}}
<div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
    <div class="overlay-modal1 js-hide-modal1"></div>

    <div class="container">
        <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent" style="border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);">
            <button class="how-pos3 hov3 trans-04 js-hide-modal1" style="background: #575757; border-radius: 20%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('frontend/images/icons/icon-close.png') }}" alt="CLOSE" style="width: 30px;">
            </button>

            {{-- Loader --}}
            <div id="modal1-loader" class="txt-center p-t-30 p-b-30" style="display:none">
                <div class="modal1-spinner"></div>
                <p class="stext-107 cl6 p-t-15">Chargement...</p>
            </div>

            {{-- Contenu --}}
            <div id="modal1-content" class="row" style="display:none">

                {{-- Galerie --}}
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">
                            {{-- Thumbnails verticaux à gauche --}}
                            <div class="wrap-slick3-dots" id="modal1-thumbs"></div>
                            
                            {{-- Flèches + image principale --}}
                            <div class="wrap-slick3-arrows flex-sb-m flex-w" style="position:relative; flex:1;">
                                <div id="modal1-slick-arrows" class="flex-sb-m w-full" style="position:absolute;top:50%;transform:translateY(-50%);z-index:10;pointer-events:none;"></div>
                                <div class="slick3 gallery-lb" id="modal1-slick"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Infos produit --}}
                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-20 p-t-5 p-lr-0-lg" style="max-height: 600px; overflow-y: auto; padding-right: 15px;">

                        {{-- Badges statut / vedette --}}
                        <div id="modal1-badges" class="p-b-15"></div>

                        {{-- Nom --}}
                        <h4 class="mtext-105 cl2 js-name-detail p-b-12" id="modal1-name" style="font-size: 24px; line-height: 1.3;"></h4>

                        {{-- Prix --}}
                        <div id="modal1-price" class="p-b-15"></div>

                        {{-- Catégorie & Marque --}}
                        <div id="modal1-meta" class="p-b-15 modal1-meta-row" style="background: #f8f9fa; border-radius: 12px; padding: 12px 15px;"></div>

                        {{-- Description --}}
                        <div class="p-b-15">
                            <div class="modal1-section-title">Description</div>
                            <p class="stext-102 cl3 p-t-5" id="modal1-desc" style="line-height: 1.6;"></p>
                        </div>

                        {{-- Couleurs --}}
                        <div id="modal1-colors-wrap" class="p-b-20" style="display:none">
                            <div class="modal1-section-title">Couleurs disponibles</div>
                            <div class="modal1-colors-list" id="modal1-colors-list" style="margin-top: 12px;"></div>
                        </div>

                        {{-- Spécifications --}}
                        <div id="modal1-specs-wrap" class="p-b-20" style="display:none">
                            <div class="modal1-section-title">Spécifications techniques</div>
                            <div class="modal1-specs-container" id="modal1-specs-list" style="margin-top: 12px;"></div>
                        </div>

                        {{-- Alerte tarif --}}
                        <div class="p-b-20">
                            <div class="modal1-price-alert">
                                <i class="zmdi zmdi-info-outline"></i>
                                <span>Pour garantir l'exactitude du tarif affiché, merci de nous contacter afin de confirmer le prix actuel de l'article.</span>
                            </div>
                        </div>

                        {{-- Quantité + Panier --}}
                        <div class="p-t-10">
                            <div class="modal1-cart-section">
                                <div class="modal1-qty-wrapper">
                                    {{-- <label class="modal1-qty-label">Quantité</label> --}}
                                    <div class="wrap-num-product flex-w">
                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" id="modal1-qty-down">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>
                                        <input class="mtext-104 cl3 txt-center num-product"
                                            type="number" id="modal1-qty" value="1" min="1">
                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" id="modal1-qty-up">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>
                                    </div>
                                </div>
                                <button class="modal1-add-cart-btn" id="modal1-add-cart">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                                        <line x1="3" y1="6" x2="21" y2="6"/>
                                        <path d="M16 10a4 4 0 01-8 0"/>
                                    </svg>
                                    Ajouter au panier
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>{{-- /modal1-content --}}
        </div>
    </div>
</div>

<style>
	/* ================================================================
   MODAL QUICK VIEW - DESIGN AMÉLIORÉ
   ================================================================ */

/* Section title */
.modal1-section-title {
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #999;
    margin-bottom: 8px;
}

/* Description */
#modal1-desc {
    color: #555;
    font-size: 14px;
    line-height: 1.6;
}

/* Meta info (catégorie & marque) */
.modal1-meta-row {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    background: #f8f9fa;
    border-radius: 12px;
    padding: 12px 15px;
}
.modal1-meta-item {
    display: flex;
    align-items: baseline;
    gap: 8px;
    font-size: 13px;
    color: #666;
}
.modal1-meta-item strong {
    color: #333;
    font-weight: 600;
}
.modal1-meta-item::before {
    content: "•";
    color: #1e40af;
    font-weight: bold;
}
.modal1-meta-item:first-child::before {
    content: "";
    display: none;
}

/* Price styling */
.modal1-price-main {
    font-size: 28px;
    font-weight: 800;
    color: #1a1a1a;
}
.modal1-price-old {
    font-size: 18px;
    color: #999;
    text-decoration: line-through;
    margin-right: 10px;
}
.modal1-discount {
    display: inline-block;
    background: linear-gradient(135deg, #e65540, #d43f2a);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
    margin-left: 10px;
    vertical-align: middle;
}

/* Colors */
.modal1-colors-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.modal1-color-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 40px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    background: #fff;
    transition: all 0.2s ease;
}
.modal1-color-btn:hover {
    border-color: #717fe0;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(113, 127, 224, 0.15);
}
.modal1-color-btn.active {
    border-color: #717fe0;
    background: #f5f6ff;
    color: #717fe0;
}
.modal1-color-dot {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 2px solid rgba(0,0,0,0.1);
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}
.modal1-color-stock {
    font-size: 11px;
    color: #9ca3af;
    margin-left: 4px;
}

/* Specifications */
.modal1-specs-container {
    background: #f9fafb;
    border-radius: 12px;
    padding: 12px 0;
}
.modal1-spec-row {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    padding: 10px 16px;
    font-size: 13px;
    border-bottom: 1px solid #e5e7eb;
}
.modal1-spec-row:last-child {
    border-bottom: none;
}
.modal1-spec-key {
    color: #6b7280;
    font-weight: 500;
}
.modal1-spec-val {
    color: #1f2937;
    font-weight: 600;
    text-align: right;
    max-width: 60%;
}

/* Price alert */
.modal1-price-alert {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 12px;
    padding: 12px 16px;
}
.modal1-price-alert i {
    color: #3b82f6;
    font-size: 20px;
    flex-shrink: 0;
    margin-top: 2px;
}
.modal1-price-alert span {
    font-size: 14px;
    color: #1e40af;
    line-height: 1.5;
    font-weight: 800;
}

/* Cart section */
.modal1-cart-section {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
    padding-top: 10px;
    border-top: 1px solid #e5e7eb;
}
.modal1-qty-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
}
.modal1-qty-label {
    font-size: 14px;
    font-weight: 500;
    color: #374151;
}
.wrap-num-product {
    display: flex;
    align-items: center;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
}
.btn-num-product-down,
.btn-num-product-up {
    width: 62px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    background: #f9fafb;
    transition: all 0.2s;
    color: #6b7280;
}
.btn-num-product-down:hover,
.btn-num-product-up:hover {
    background: #1e40af;
    color: #fff;
}
.num-product {
    width: 50px;
    text-align: center;
    border: none;
    font-weight: 600;
    font-size: 16px;
    padding: 8px 0;
}
.num-product:focus {
    outline: none;
}
.modal1-add-cart-btn {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: #fff;
    border: none;
    padding: 12px 24px;
    border-radius: 15px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(113, 127, 224, 0.3);
}
.modal1-add-cart-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(113, 127, 224, 0.4);
    background: linear-gradient(135deg, #1e40af, #3b82f6);
}
.modal1-add-cart-btn:active {
    transform: translateY(0);
}

/* Badges */
.modal1-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.03em;
    padding: 4px 12px;
    border-radius: 20px;
    margin-right: 8px;
}
.modal1-badge-featured {
    background: #fef3c7;
    color: #d97706;
}
.modal1-badge-new {
    background: #d1fae5;
    color: #059669;
}
.modal1-badge-featured::before {
    content: "⭐";
    font-size: 12px;
}
.modal1-badge-new::before {
    content: "🆕";
    font-size: 10px;
}

/* Scrollbar personnalisée pour la section détails */
.p-r-20::-webkit-scrollbar {
    width: 4px;
}
.p-r-20::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}
.p-r-20::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}
.p-r-20::-webkit-scrollbar-thumb:hover {
    background: #1e40af;
}
</style>