@extends('public.layout.master')

@section('title', settings('app_title') ? settings('app_title') : 'Wishlists')


@section('content')
<!-- ======= Breadcrumbs ======= -->
{!! \App\Library\Html::breadcrumbsSection('Wishlist') !!}
<!-- End Breadcrumbs -->

<section class="wishlist-section section-b-space">
    <div class="container-fluid-lg">
        <h4 class="text-center">{{count($wishlists) > 0 ? "" : "There are no items in this wishlist..."}}</h4>
        <div class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-4 row-cols-lg-4 row-cols-md-2 row-cols-2 product-list-section">
            @foreach ($wishlists as $wishlist)
            <div>
                <div class="product-box-4 custom-product product-wishlist-box">
                    <div class="product-image">
                        <div class="label-flex">
                            <div class="wishlist">
                                <button class="btn p-0 close-btn delete-wishlist">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                        <div class="product-card-rating">
                            <span>{{ $wishlist->product->getOverallRetting(true) }}</span>
                            <i class="fa fa-star text-yellow mx-1"></i>
                            <span>5</span>
                        </div>
                        <input type="hidden" name="product_id" class="product_id" value="{{ $wishlist->product->id }}">
                        <input type="hidden" name="user_id" class="user_id" value="{{ authUser()?->id }}">

                        <a href="{{ route('public.product.show', $wishlist->product->slug) }}">
                            <img src="{{ $wishlist->product->getThumbnailImage() }}" class="img-fluid" alt="">
                        </a>
                    </div>

                    <div class="product-detail">
                        {{-- {!! \App\Library\Html::rating($wishlist->product->getOverallRetting(true)) !!} --}}
                        <a href="{{ route('public.product.show', $wishlist->product->slug) }}">
                            <h5 class="d-none d-md-block" title="{{$wishlist->product->getTranslation('title')}}">{{ $wishlist->product->getTranslation('short_title') }}</h5>
                            <h5 class="d-md-none" title="{{$wishlist->product->getTranslation('title')}}">{{ $wishlist->product->getTranslation('mobile_short_title') }}</h5>
                            
                        </a>
                        @php
                            //$ezzicoDiscount = $wishlist->product->getEzzicoDiscount($wishlist->product->getPriceAfterDiscount());
                            $firstStock = $wishlist->product->productStock()->first()->unit_price;
                            $ezzicoDiscount = $wishlist->product->getEzzicoDiscount($firstStock);
                        @endphp

                        @if ($wishlist->product->has_discount)
                            <h5 class="price theme-color">{{ getFormattedAmount($wishlist->product->getPriceAfterDiscount() - $ezzicoDiscount) }}
                                <del class="text-content fs-6">{{ getFormattedAmount(getUnitPrice($wishlist->product)) }} </del>
                            </h5>
                        @else
                            <h5 class="price theme-color">{{ getFormattedAmount(getUnitPrice($wishlist->product) - $ezzicoDiscount) }}
                                @if($ezzicoDiscount > 0)
                                    <del class="text-content fs-6">{{ getFormattedAmount(getUnitPrice($wishlist->product)) }} </del>
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
                                        max="{{ $wishlist->product?->load('productStocks')->productStocks->count() ? $wishlist->product?->productStocks[0]?->current_stock : 0 }}">
                                    <div class="qty-right-plus plus" data-type="plus" data-field="">
                                        <i class="fa-solid fa-plus"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-content-center" style="gap: 4px;">
                                <div class="w-50">
                                    @if($wishlist->product->has_variant && count($wishlist->product->productStocks) > 1)
                                        <a class="d-block w-100" href="{{ route('public.product.show', $wishlist->product->slug) }}">
                                            <button class="buy-button position-static buy-button-2 btn w-100">
                                                Buy Now
                                            </button>
                                        </a>
                                    @else
                                        <button class="buy-button position-static buy-button-2 btn w-100 buyNow" {{ $wishlist->product->current_stock > 0 ? '' : 'disabled' }}>
                                            Buy Now
                                        </button>
                                    @endif
                                </div>
                                <div class="w-50">
                                    @if($wishlist->product->has_variant && count($wishlist->product->productStocks) > 1)
                                        <a class="d-block w-100" href="{{ route('public.product.show', $wishlist->product->slug) }}">
                                            <button class="buy-button position-static buy-button-2 btn d-block w-100">
                                                Add to Cart
                                            </button>
                                        </a>
                                    @else
                                        <button class="buy-button position-static buy-button-2 btn btn-cart w-100" {{ $wishlist->product->current_stock > 0 ? '' : 'disabled' }}>
                                            Add to Cart
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="#">
                        <input type="hidden" name="product_id" class="product_id" value="{{ $wishlist->product->id }}">
                        <input type="hidden" name="user_id" class="user_id" value="{{ authUser()?->id }}">
                        <input type="hidden" name="current_stock" class="current_stock" value="{{ $wishlist->product->current_stock }}">
                        <input type="hidden" name="product_price" class="product_price" value="{{ $wishlist->product->unit_price }}">
                        <input type="hidden" name="product_slug" class="product_slug" value="{{ $wishlist->product->slug }}">
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('scripts')
    @vite('resources/frontend_assets/js/pages/cart/addToCart.js')

    <script>
        // Event listener for checkout button
        $(document).on('click', '.buyNow', function () {
                $(this).prop('disabled', true);

                var productId = $(this).closest('.product-box-4').find('input[name="product_id"]').val();
                var unitPrice = $(this).closest('.product-box-4').find('input[name="product_price"]').val();
                var product_slug = $(this).closest('.product-box-4').find('input[name="product_slug"]').val();
                var quantity = parseInt($(this).closest('.product-box-4').find('.qty-input').val());
                var ezzicoDiscount = $(this).closest('.product-box-4').find('input[name="ezzico_discount"]').val();
                var selectedColor = $(this).closest('.product-box-4').find('input[name="color"]:checked').val();
                var selectedVariants = [];
                
                $('input[type="radio"].attribute:checked').each(function() {
                    selectedVariants.push($(this).val());
                });
            
                $.ajax({
                    url: '/buy-now',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        product_id: productId,
                        quantity: quantity,
                        price: unitPrice,
                        ezzico_discount: ezzicoDiscount,
                        color: selectedColor,
                        variants: selectedVariants,
                        buy_now: 'buy_now',
                        product_slug: product_slug,
                    },
                    success: function(response) {
                        var guestCheckout = response.guestCheckout;
                        var isAuthenticated = response.isAuthenticated;

                        if (isAuthenticated || guestCheckout) {
                            window.location.href = '/checkout';
                        } else {
                            window.location.href = '/login';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error updating cart data:', error);
                    }
                });
            });
    </script>
@endpush