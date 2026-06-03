<div class="wow fadeInUp mt-0" data-wow-delay="{{ 0.05 * $key }}s">
    <div class="product-box-4 custom-product">
        <div class="product-image">
            <div class="label-flex">
                <button class="btn p-0 wishlist btn-wishlist {{$product->wishlist()->where('user_id', authUser()?->id)->first() ? "text-danger" : ""}}">
                    <i class="iconly-Heart icli"></i>
                </button>
            </div>

            <div class="product-card-rating">
                    <span>{{ $product->getOverallRetting(true) }}</span>
                    <i class="fa fa-star text-yellow mx-1"></i>
                    <span>5</span>
            </div>

            <a href="{{ route('public.product.show', $product->slug) }}">
                <img data-src="{{ $product->getThumbnailImage() }}" class="img-fluid lazyload" alt="">
            </a>
        </div>

        <div class="product-detail">
            {{-- {!! \App\Library\Html::rating($product->getOverallRetting(true)) !!} --}}

            <a href="{{ route('public.product.show', $product->slug) }}">
                <h5 class="d-none d-md-block" title="{{$product->getTranslation('title')}}">{{ $product->getTranslation('short_title') }}</h5>
                <h5 class="d-md-none" title="{{$product->getTranslation('title')}}">{{ $product->getTranslation('mobile_short_title') }}</h5>
                
            </a>

            @php
                //$ezzicoDiscount = $product->getEzzicoDiscount($product->getPriceAfterDiscount());
                $firstStock = $product->productStock()->first()->unit_price;
                $ezzicoDiscount = $product->getEzzicoDiscount($firstStock);
            @endphp

            @if ($product->has_discount)
                <h5 class="price theme-color">{{ getFormattedAmount($product->getPriceAfterDiscount() - $ezzicoDiscount) }}
                    <del class="text-content fs-6">{{ getFormattedAmount(getUnitPrice($product)) }} </del>
                </h5>
            @else
                <h5 class="price theme-color">{{ getFormattedAmount(getUnitPrice($product) - $ezzicoDiscount) }}
                    @if($ezzicoDiscount > 0)
                        <del class="text-content fs-6">{{ getFormattedAmount(getUnitPrice($product)) }} </del>
                    @endif
                </h5>
            @endif

            <div class="price-qty">
                <div class="counter-number">
                    <div class="counter quantity">
                        <div class="qty-left-minus minus" data-type="minus" data-field="">
                            <i class="fa-solid fa-minus"></i>
                        </div>
                        <input class="form-control input-number qty-input product_quantity" type="number"
                            name="quantity" value="1" min="1"
                            max="{{ $product?->load('productStocks')->productStocks->count() ? $product?->productStocks[0]->current_stock : 0 }}">
                        <div class="qty-right-plus plus" data-type="plus" data-field="">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-content-center" style="gap: 4px;">
                    <div class="w-50">
                        @if($product->has_variant && count($product->productStocks) > 1)
                            <a class="d-block w-100" href="{{ route('public.product.show', $product->slug) }}">
                                <button class="buy-button position-static buy-button-2 btn w-100">
                                    Buy Now
                                </button>
                            </a>
                        @else
                            <button class="buy-button position-static buy-button-2 btn w-100 buyNow" {{ $product->current_stock > 0 ? '' : 'disabled' }}>
                                Buy Now
                            </button>
                        @endif
                    </div>
                    <div class="w-50">
                        @if($product->has_variant && count($product->productStocks) > 1)
                            <a class="d-block w-100" href="{{ route('public.product.show', $product->slug) }}">
                                <button class="buy-button position-static buy-button-2 btn d-block w-100">
                                    Add to Cart
                                </button>
                            </a>
                        @else
                            <button class="buy-button position-static buy-button-2 btn btn-cart w-100" {{ $product->current_stock > 0 ? '' : 'disabled' }}>
                                Add to Cart
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <form action="#">
            <input type="hidden" name="product_id" class="product_id" value="{{ $product->id }}">
            <input type="hidden" name="user_id" class="user_id" value="{{ authUser()?->id }}">
            <input type="hidden" name="current_stock" class="current_stock" value="{{ $product->current_stock }}">
            <input type="hidden" name="product_price" class="product_price" value="{{ $product->unit_price }}">
            <input type="hidden" name="ezzico_discount" class="ezzico_discount" value="{{ $ezzicoDiscount }}">
            <input type="hidden" name="product_slug" class="product_slug" value="{{ $product->slug }}">
        </form>
    </div>
</div>

@push('scripts')
    @vite('resources/frontend_assets/js/pages/cart/addToCart.js')
@endpush
