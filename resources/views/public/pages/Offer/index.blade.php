@extends('public.layout.master')

@section('title', settings('app_title') ? settings('app_title') : 'Offers')

@section('content')
<!-- Offers Banner start -->
<section class="offers-banner">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="offers-text text-center text-md-start">
                    <h1>Spacial Offers</h1>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <img src="{{ Vite::asset(\App\Library\Enum::OFFER_IMAGE1) }}" class="d-block d-lg-none mx-auto"
                    alt="Offer Banner Image">
                <img src="{{ Vite::asset(\App\Library\Enum::OFFER_IMAGE2) }}" class="d-none d-lg-block"
                    alt="Offer Banner Image">
            </div>
        </div>
    </div>
</section>
<!-- Offers Banner end -->

<!-- Spacial Offers Start -->
<section class="products-section pb-5">
    <div class="container-fluid-lg">
        <div>
            <h2 class="text-center">{{$ezzico_sales->count() ? "Spacial Offers" : 'Offers are not Available'}}</h2>
        </div>

        <div class="row g-sm-4 g-3 row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 product-div">
            @foreach ($ezzico_sales as $key => $ezzico_sale)
            {{-- <div class="wow fadeInUp" data-wow-delay="{{ 0.05 * $key }}s">
                <div class="product-box-4">
                    <div class="product-image">
                        <div class="label-flex">
                            @php
                            $wishlist = authUser()?->wishlist()->where('product_id',
                            $ezzico_sale->product->id)->first();
                            @endphp
                            <button class="btn p-0 wishlist btn-wishlist {{$wishlist ? 'text-danger' : ''}}">
                                <i class="iconly-Heart icli"></i>
                            </button>
                        </div>

                        <a href="{{ route('public.product.show', $ezzico_sale->product->slug) }}">
                            <img src="{{ $ezzico_sale->product->getThumbnailImage() }}" class="img-fluid" alt="">
                        </a>
                    </div>

                    <div class="product-detail">
                        {!! \App\Library\Html::rating($ezzico_sale->product->getOverallRetting(true)) !!}

                        <a href="{{ route('public.product.show', $ezzico_sale->product->slug) }}">
                            <h5 title="{{$ezzico_sale->product->getTranslation('title')}}">{{ $ezzico_sale->product->getTranslation('short_title') }}</h5>
                        </a>
                        <h5 class="price theme-color">{{
                            getFormattedAmount($ezzico_sale->product->getPriceAfterDiscount()) }}
                            @if ($ezzico_sale->product->productDetails?->discount)
                            <del class="text-content fs-6">{{ getFormattedAmount($ezzico_sale->product->unit_price) }}
                            </del>
                            @endif
                        </h5>
                        <div class="price-qty">
                            <div class="counter-number">
                                <div class="counter quantity">
                                    <div class="qty-left-minus minus" data-type="minus" data-field="">
                                        <i class="fa-solid fa-minus"></i>
                                    </div>
                                    <input class="form-control input-number qty-input product_quantity" type="number"
                                        name="quantity" value="1" min="1"
                                        max="{{ $ezzico_sale->product?->productStocks->count() ? $ezzico_sale->product?->productStocks[0]->current_stock : 0 }}">
                                    <div class="qty-right-plus plus" data-type="plus" data-field="">
                                        <i class="fa-solid fa-plus"></i>
                                    </div>
                                </div>
                            </div>

                            @if($ezzico_sale->product->has_variant)
                            <a href="{{ route('public.product.show', $ezzico_sale->product->slug) }}">
                                <button class="buy-button buy-button-2 btn">
                                    <i class="iconly-Buy icli text-white m-0"></i>
                                </button>
                            </a>
                            @else
                            <button class="buy-button buy-button-2 btn btn-cart">
                                <i class="iconly-Buy icli text-white m-0"></i>
                            </button>
                            @endif
                        </div>
                    </div>

                    <form action="#">
                        <input type="hidden" name="product_id" class="product_id"
                            value="{{ $ezzico_sale->product->id }}">
                        <input type="hidden" name="user_id" class="user_id" value="{{ authUser()?->id }}">
                        <input type="hidden" name="current_stock" class="current_stock"
                            value="{{ $ezzico_sale->product->current_stock }}">
                        <input type="hidden" name="product_price" class="product_price"
                            value="{{ $ezzico_sale->product->unit_price }}">
                    </form>

                </div>
            </div> --}}
            @include('public.pages.product.product', ['product' => $ezzico_sale])
            @endforeach
        </div>

        @if ($ezzico_sales->count() > 2)
            <button class="btn theme-bg-color mt-4 btn-md mx-auto text-white py-2 fw-bold {{$ezzico_sales->count() ? '' : 'd-none'}}" id="load_more">
                Load More
            </button>
        @endif
    </div>
</section>
<!-- Spacial Offers End -->
@endsection
@push('scripts')
@vite('resources/frontend_assets/js/my-wishlist.js')
<script>
    $(document).ready(function() {
            var start = 15;

            $('#load_more').click(function() {
                $.ajax({
                    url: "{{ route('public.offer.load.more') }}",
                    method: "GET",
                    data: {
                        start: start
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('#load_more').html('Loading...');
                        $('#load_more').attr('disabled', true);
                    },
                    success: function(data) {
                        if (data.data.length > 0) {

                            //append data with fade in effect
                            $('.product-div').append($(data.data).hide().fadeIn(1000));
                            $('#load_more').html('Load More');
                            $('#load_more').attr('disabled', false);
                            start = data.next;
                        } else {
                            $('#load_more').html('No More Data Available');
                            $('#load_more').attr('disabled', true);
                        }
                    }
                });
            });
        });
</script>
@endpush
