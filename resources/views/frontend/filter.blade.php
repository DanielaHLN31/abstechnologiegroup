<div class="flex-w flex-c-m m-tb-10" style="margin-right: 10rem !important; justify-content:end !important">
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
    <div class="bor8 dis-flex p-l-15" style="background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
            <i class="zmdi zmdi-search"></i>
        </button>
        <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" id="search-product" 
               placeholder="Rechercher un produit..." style="border: none; outline: none;">
    </div>
</div>

<!-- Filter - Design Amélioré -->
<div class="dis-none panel-filter w-full p-t-10">
    <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm" style="border-radius: 16px; background: #fff; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
        
        <!-- ══ COULEURS ══ -->
        <div class="filter-col1 p-r-15 p-b-27">
            <div class="mtext-102 cl2 p-b-15" style="font-size: 14px; font-weight: 700; color: #1a1a1a;">
                <i class="zmdi zmdi-palette m-r-8" style="color: #0066CC;"></i>Couleurs
            </div>

            <div class="flex-w p-t-4 m-r--5"
                style="max-height:200px; overflow-y:auto; padding-right:4px;
                        scrollbar-width:thin; scrollbar-color:#ccc transparent;">
                <a href="#" class="filter-color-link flex-c-m trans-04 m-r-8 m-b-8 filter-link-active"
                data-color="all"
                style="width:32px;height:32px;border-radius:50%;background:#fff;border:2px solid #ddd;"
                title="Toutes">
                    <i class="zmdi zmdi-check fs-12" style="color:#aaa;"></i>
                </a>
                @foreach($colors as $color)
                <a href="#" class="filter-color-link trans-04 m-r-8 m-b-8"
                data-color="{{ $color->id }}"
                style="width:32px;height:32px;border-radius:50%;background:{{ $color->code }};border:2px solid transparent;display:inline-block;box-shadow: 0 2px 4px rgba(0,0,0,0.1);transition: all 0.2s;"
                title="{{ $color->name }}">
                </a>
                @endforeach
            </div>
        </div>

        <!-- ══ PRIX ══ -->
        <div class="filter-col2 p-r-15 p-b-27">
            <div class="mtext-102 cl2 p-b-15" style="font-size: 14px; font-weight: 700; color: #1a1a1a;">
                <i class="zmdi zmdi-money m-r-8" style="color: #0066CC;"></i>Prix
            </div>
            <ul style="list-style: none; padding: 0; margin: 0;">
                <li class="p-b-8">
                    <a href="#" class="filter-link stext-106 trans-04 filter-link-active" data-price="all" 
                       style="display: inline-block; padding: 4px 0; text-decoration: none;">Tous les prix</a>
                </li>
                <li class="p-b-8">
                    <a href="#" class="filter-link stext-106 trans-04" data-price="0-50000"
                       style="display: inline-block; padding: 4px 0; text-decoration: none;">Moins de 50 000 FCFA</a>
                </li>
                <li class="p-b-8">
                    <a href="#" class="filter-link stext-106 trans-04" data-price="50000-100000"
                       style="display: inline-block; padding: 4px 0; text-decoration: none;">50 000 – 100 000 FCFA</a>
                </li>
                <li class="p-b-8">
                    <a href="#" class="filter-link stext-106 trans-04" data-price="100000-250000"
                       style="display: inline-block; padding: 4px 0; text-decoration: none;">100 000 – 250 000 FCFA</a>
                </li>
                <li class="p-b-8">
                    <a href="#" class="filter-link stext-106 trans-04" data-price="250000-500000"
                       style="display: inline-block; padding: 4px 0; text-decoration: none;">250 000 – 500 000 FCFA</a>
                </li>
                <li class="p-b-8">
                    <a href="#" class="filter-link stext-106 trans-04" data-price="500000+"
                       style="display: inline-block; padding: 4px 0; text-decoration: none;">Plus de 500 000 FCFA</a>
                </li>
            </ul>
        </div>

        <!-- ══ CATÉGORIES ══ -->
        <div class="filter-col3 p-r-15 p-b-27">
            <div class="mtext-102 cl2 p-b-15" style="font-size: 14px; font-weight: 700; color: #1a1a1a;">
                <i class="zmdi zmdi-view-list m-r-8" style="color: #0066CC;"></i>Catégories
            </div>
            <ul style="list-style: none; padding: 0; margin: 0; max-height: 200px; overflow-y: auto;">
                <li class="p-b-8">
                    <a href="#" class="filter-link stext-106 trans-04 filter-link-active" data-category="all"
                       style="display: inline-block; padding: 4px 0; text-decoration: none;">Toutes les catégories</a>
                </li>
                @foreach($categories as $category)
                <li class="p-b-8">
                    <a href="#" class="filter-link stext-106 trans-04" data-category="{{ $category->id }}"
                       style="display: inline-block; padding: 4px 0; text-decoration: none;">
                        {{ $category->name }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- ══ MARQUES ══ -->
        <div class="filter-col4 p-b-27">
            <div class="mtext-102 cl2 p-b-15" style="font-size: 14px; font-weight: 700; color: #1a1a1a;">
                <i class="zmdi zmdi-tag m-r-8" style="color: #0066CC;"></i>Marques
            </div>

            <div class="flex-w p-t-4 m-r--5" id="brand-list" style="max-height: 200px; overflow-y: auto;">
                <a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5"
                   data-brand="all" style="background: #f5f5f5; border-radius: 20px; padding: 6px 14px; text-decoration: none;">
                    Toutes
                </a>

                @foreach($brands as $index => $brand)
                <a href="#"
                   class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 brand-tag {{ $index >= 6 ? 'brand-extra' : '' }}"
                   data-brand="{{ $brand->id }}"
                   style="background: #f5f5f5; border-radius: 20px; padding: 6px 14px; text-decoration: none; transition: all 0.2s;"
                   @if($index >= 6) style="display:none;" @endif>
                    {{ $brand->name }}
                </a>
                @endforeach
            </div>

            @if($brands->count() > 6)
            <button id="brand-toggle"
                    class="brand-toggle-btn"
                    style="margin-top: 12px; background: none; border: none; padding: 6px 12px;
                           font-size: 12px; color: #0066CC; cursor: pointer; font-weight: 600;
                           display: inline-flex; align-items: center; gap: 5px; border-radius: 20px;
                           transition: all 0.2s;">
                <i class="zmdi zmdi-plus"></i>
                <span>Voir toutes les marques ({{ $brands->count() }})</span>
            </button>
            @endif
        </div>

        <!-- ══ BOUTON RÉINITIALISER ══ -->
        <div class="filter-col4 p-b-27" style="width: 100%;">
            <button id="reset-filters" class="reset-filters-btn" style="
                width: 100%;
                padding: 12px;
                background: #f5f5f5;
                border: none;
                border-radius: 40px;
                color: #666;
                font-size: 13px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            ">
                <i class="zmdi zmdi-close-circle"></i>
                Réinitialiser tous les filtres
            </button>
        </div>

    </div>
</div>

<style>
/* Styles supplémentaires pour les filtres */
.filter-link {
    position: relative;
    display: inline-block;
    color: #6b7a99;
    font-size: 13px;
    transition: all 0.2s;
}

.filter-link:hover {
    color: #0066CC;
    transform: translateX(3px);
}

.filter-link-active {
    color: #0066CC;
    font-weight: 600;
}

.filter-link-active::before {
    content: '';
    position: absolute;
    left: 0;
    bottom: -2px;
    width: 100%;
    height: 2px;
    background: #0066CC;
    border-radius: 2px;
}

/* Animation pour l'ouverture du panneau */
.panel-search,
.panel-filter {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Style des tags de marques au hover */
.brand-tag:hover {
    background: #0066CC !important;
    color: white !important;
    transform: translateY(-2px);
}

/* Style du bouton de réinitialisation */
.reset-filters-btn:hover {
    background: #e65540;
    color: white;
}

.reset-filters-btn:hover i {
    color: white;
}

/* Scrollbar personnalisée */
.filter-col1 .flex-w::-webkit-scrollbar,
.filter-col3 ul::-webkit-scrollbar,
#brand-list::-webkit-scrollbar {
    width: 4px;
}

.filter-col1 .flex-w::-webkit-scrollbar-track,
.filter-col3 ul::-webkit-scrollbar-track,
#brand-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.filter-col1 .flex-w::-webkit-scrollbar-thumb,
.filter-col3 ul::-webkit-scrollbar-thumb,
#brand-list::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}

.filter-col1 .flex-w::-webkit-scrollbar-thumb:hover,
.filter-col3 ul::-webkit-scrollbar-thumb:hover,
#brand-list::-webkit-scrollbar-thumb:hover {
    background: #0066CC;
}

/* Style des pastilles de couleur */
.filter-color-link {
    cursor: pointer;
    transition: all 0.2s;
}

.filter-color-link:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.filter-color-link.active {
    border-color: #0066CC !important;
    transform: scale(1.05);
}

/* Responsive */
@media (max-width: 767px) {
    .wrap-filter {
        padding: 20px !important;
    }
    
    .filter-col1,
    .filter-col2,
    .filter-col3,
    .filter-col4 {
        width: 100%;
        margin-bottom: 20px;
    }
}
</style>

<script>
function toggleBrands() {
    const extras = document.querySelectorAll('.brand-extra');
    const btn = document.getElementById('brand-toggle');
    const isHidden = extras[0]?.style.display === 'none';
    
    extras.forEach(el => {
        el.style.display = isHidden ? 'inline-flex' : 'none';
    });
    
    if (btn) {
        btn.innerHTML = isHidden 
            ? '<i class="zmdi zmdi-minus"></i><span>Voir moins</span>'
            : '<i class="zmdi zmdi-plus"></i><span>Voir toutes les marques ({{ $brands->count() }})</span>';
    }
}

// Gestion de l'état actif des filtres
$(document).ready(function() {
    // Gestion des filtres de couleur
    $('.filter-color-link').on('click', function(e) {
        e.preventDefault();
        $('.filter-color-link').removeClass('active');
        $(this).addClass('active');
        
        // Mettre à jour les données du filtre
        const colorId = $(this).data('color');
        // Appeler votre fonction de filtrage ici
    });
    
    // Réinitialisation des filtres
    $('#reset-filters').on('click', function() {
        // Réinitialiser tous les filtres actifs
        $('.filter-link-active').removeClass('filter-link-active');
        $('[data-category="all"]').addClass('filter-link-active');
        $('[data-price="all"]').addClass('filter-link-active');
        $('[data-brand="all"]').addClass('filter-link-active');
        $('.filter-color-link').removeClass('active');
        $('[data-color="all"]').addClass('active');
        
        // Appeler votre fonction de réinitialisation
        // fetchProducts();
    });
});
</script>