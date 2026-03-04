@foreach($products as $product)
<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item cat-{{ $product->category_id }}"
    data-brand-id="{{ $product->brand_id }}"
    data-colors="{{ json_encode($product->colors) }}">
    <div class="block2">
        <div class="block2-pic hov-img0">
            @if($product->images->isNotEmpty())
                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}">
            @else
                <img src="{{ asset('frontend/images/no-image.jpg') }}" alt="No Image">
            @endif

            <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1"
                data-product-id="{{ $product->id ?? '' }}"
                data-product-name="{{ $product->name ?? '' }}"
                data-product-price="{{ $product->price ?? '' }}"
                data-product-description="{{ $product->description ?? '' }}"
                data-product-images="{{ json_encode($product->images) }}"
                data-product-colors="{{ json_encode($product->colors) }}"
                data-product-specs="{{ json_encode($product->specifications) }}">
                    Voir
            </a>
        </div>

        <div class="block2-txt flex-w flex-t p-t-14">
            <div class="block2-txt-child1 flex-col-l">
                <a href="{{ route('client.product.detail', $product->id) }}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                    {{ $product->name }}
                </a>
                <span class="stext-105 cl3">
                    @if($product->compare_price && $product->compare_price > $product->price)
                        <span class="text-decoration-line-through text-muted">{{ number_format($product->compare_price, 0, ',', ' ') }} FCFA</span>
                        <span class="text-danger ml-2">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                    @else
                        {{ number_format($product->price, 0, ',', ' ') }} FCFA
                    @endif
                </span>
                @if($product->colors->isNotEmpty())
                <div class="mt-2">
                    @foreach($product->colors->take(3) as $color)
                    <span class="d-inline-block rounded-circle mr-1"
                        style="width:15px;height:15px;background-color:{{ $color->code }};border:1px solid #ddd;"
                        title="{{ $color->name }}"></span>
                    @endforeach
                    @if($product->colors->count() > 3)
                    <span class="small text-muted">+{{ $product->colors->count() - 3 }}</span>
                    @endif
                </div>
                @endif
            </div>
            <div class="block2-txt-child2 flex-r p-t-3">
                <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2" data-product-id="{{ $product->id }}">
                    <img class="icon-heart1 dis-block trans-04" src="{{ asset('frontend/images/icons/icon-heart-01.png') }}" alt="ICON">
                    <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{ asset('frontend/images/icons/icon-heart-02.png') }}" alt="ICON">
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach