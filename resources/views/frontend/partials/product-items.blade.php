@forelse($products as $product)
<div class="ps-card" 
     data-cat="cat-{{ $product->category_id }}"
     data-brand-id="{{ $product->brand_id }}"
     data-colors="{{ json_encode($product->colors) }}">
    
    
    {{-- Zone image --}}
    <div class="ps-card-img">

        @if($product->images->isNotEmpty())
            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                 alt="{{ $product->name }}" loading="lazy">
        @else
            <img src="{{ asset('frontend/images/no-image.jpg') }}"
                 alt="{{ $product->name }}" loading="lazy">
        @endif

        {{-- Badge (Promo > Nouveau > Top Vente) --}}
        @if($product->compare_price && $product->compare_price > $product->price)
            @php $discount = round((1 - $product->price / $product->compare_price) * 100); @endphp
            <span class="ps-badge badge-promo">-{{ $discount }}%</span>
        @elseif($product->created_at->diffInDays(now()) <= 30)
            <span class="ps-badge badge-new">Nouveau</span>
        @elseif($product->is_featured ?? false)
            <span class="ps-badge badge-top">Top Vente</span>
        @endif

        {{-- Bouton Favori --}}
        <button class="ps-wish js-addwish-b2"
                data-product-id="{{ $product->id }}"
                title="Ajouter aux favoris">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none"
                 stroke="#CC1B1B" stroke-width="2">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67
                         l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06
                         L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
        </button>

        {{-- Aperçu rapide --}}
        <div class="ps-quickview js-show-modal1"
             data-product-id="{{ $product->id }}"
             data-product-name="{{ $product->name }}"
             data-product-price="{{ $product->price }}"
             data-product-description="{{ $product->description }}"
             data-product-images="{{ json_encode($product->images) }}"
             data-product-colors="{{ json_encode($product->colors) }}"
             data-product-specs="{{ json_encode($product->specifications) }}">
            Aperçu rapide
        </div>

    </div>{{-- /.ps-card-img --}}

    {{-- Corps --}}
    <div class="ps-card-body">

        <span class="ps-card-cat">
            {{ $product->category->name ?? 'Produit' }}
        </span>

        <a href="{{ route('client.product.detail', $product->id) }}"
           class="ps-card-name">
            {{ $product->name }}
        </a>

        {{-- Pastilles couleurs --}}
        @if($product->colors->isNotEmpty())
        <div class="ps-card-colors">
            @foreach($product->colors->take(4) as $color)
            <span class="ps-color-dot"
                  style="background-color:{{ $color->code }}"
                  title="{{ $color->name }}"></span>
            @endforeach
            @if($product->colors->count() > 4)
            <span style="font-size:11px;color:var(--text-muted)">
                +{{ $product->colors->count() - 4 }}
            </span>
            @endif
        </div>
        @endif

        {{-- Footer prix + panier --}}
        <div class="ps-card-footer">

            <div class="ps-price">
                @if($product->compare_price && $product->compare_price > $product->price)
                    <span class="ps-price-old">
                        {{ number_format($product->compare_price, 0, ',', ' ') }} F
                    </span>
                @endif
                <span class="ps-price-main">
                    {{ number_format($product->price, 0, ',', ' ') }} F
                </span>
            </div>

            <button class="ps-add-btn abs-add-to-cart"
                    data-product-id="{{ $product->id }}"
                    data-product-name="{{ $product->name }}"
                    data-product-price="{{ $product->price }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     width="13" height="13" stroke-width="2.5">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 01-8 0"/>
                </svg>
                Ajouter
            </button>

        </div>{{-- /.ps-card-footer --}}

    </div>{{-- /.ps-card-body --}}
    
</div>
@empty
<div style="grid-column:1/-1;text-align:center;padding:60px 0;color:var(--text-muted);">
    <i class="zmdi zmdi-search" style="font-size:40px;color:#ddd;display:block;margin-bottom:12px"></i>
    <p>Aucun produit ne correspond à votre sélection.</p>
</div>
@endforelse