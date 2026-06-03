@extends('public.layout.master')
@section('title',  __( $product->getTranslation('title')))
@push('share_info')
<meta property="og:title" constant="{{ $product->getTranslation('title') }}">
<meta property="og:image" content="{{ $product->getThumbnailImage() }}">
<link rel="icon" href="{{ $product->getThumbnailImage() }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ $product->getThumbnailImage() }}">
@endpush
@section('content')
    @php
        use App\Library\Enum;
        use Illuminate\Support\Facades\Vite;
        $variant_index = 0;
        $ezzicoDiscount = 0;
    @endphp
    <!-- ======= Breadcrumbs ======= -->
    {!! \App\Library\Html::breadcrumbsSection('Product Details') !!}
    <!-- End Breadcrumbs -->
    <!-- Product Left Sidebar Start -->
    <section class="product-section pt-3">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-10 col-xl-9 col-lg-7">
                    <div class="row g-4">
                        <div class="col-xl-6">
                            <div class="product-left-box">
                                <div class="row g-2">
                                    <div class="col-xxl-10 col-lg-12 col-md-10 order-xxl-2 order-lg-1 order-md-2">
                                        <div class="product-main-2 no-arrow">
                                            <div>
                                                <div class="slider-image">
                                                    <img src="{{ $product->getThumbnailImage() }}" id="img-0" alt=""
                                                        data-zoom-image="{{ $product->getThumbnailImage() }}" class="
                                                        img-fluid image_zoom_cls-0 blur-up lazyload thumbnail-image"
                                                    >
                                                </div>
                                            </div>

                                            @foreach ($product->attachments as $key => $attachment)
                                                <div>
                                                    <div class="slider-image">
                                                        <img src="{{ $attachment->getAttachment() }}" id="img-{{$key+1}}"
                                                            data-zoom-image="{{ $attachment->getAttachment() }}" alt=""
                                                            class="img-fluid image_zoom_cls-{{ $key }} blur-up lazyload thumbnail-image"
                                                        >
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-xxl-2 col-lg-12 col-md-2 order-xxl-1 order-lg-2 order-md-1">
                                        <div class="left-slider-image-2 left-slider no-arrow slick-top">
                                            @foreach ($product->attachments as $key => $attachment)
                                                <div>
                                                    <div class="slider-image">
                                                        <img src="{{ $attachment->getAttachment() }}" id="img-{{$key+1}}"
                                                            data-zoom-image="{{ $attachment->getAttachment() }}"
                                                            class="img-fluid blur-up lazyload" alt="">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6" data-wow-delay="0.1s">
                            <div class="right-box-contain">
                                <div class="d-flex justify-content-between ">
                                    <h2 class="name">{{ $product->getTranslation('title') }}</h2>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="media-section position-relative">
                                            <div class="share-icon">
                                                <i class="fa fa-share-alt"></i>
                                            </div>
                                            <div class="media-group">
                                                <ul class="social-share-list">
                                                    {!! $button_component !!}
                                                </ul>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="share-icon wishlist btn-wishlist {{$product->wishlist()->where('user_id', authUser()?->id)->first() ? "text-danger" : ""}}">
                                                <i class="fa fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <form action="#">
                                        <input type="hidden" name="product_id" class="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="user_id" class="user_id" value="{{ authUser()?->id }}">
                                    </form>
                                </div>
                                <div class="price-rating mb-2">
                                    <div class="product-rating custom-rate">
                                        {!! \App\Library\Html::rating($overallRetting) !!}
                                        <span class="review">{{ $product->productReview(true)->count() }} Customer
                                            Review</span>
                                    </div>
                                </div>

                                @if (isset($product->brand))
                                    <div class="mb-2">
                                        <strong>Brand :</strong>
                                        <span>{{ $product?->brand?->getTranslation('title') }}</span>
                                    </div>
                                @endif

                                <div id="stock_badge">
                                    {!! \App\Library\Html::StockBadge($first_stock->current_stock, $product->stock_visibility) !!}
                                </div>
                                <h3 class="theme-color price mt-4">
                                    @if ($product->has_discount)
                                        @php
                                            $ezzicoDiscount = $product->getEzzicoDiscount($first_stock->unit_price);
                                            //$ezzicoDiscount = $product->getEzzicoDiscount($first_stock->getPriceAfterDiscount());
                                        @endphp

                                        <span id="price">{{ getFormattedAmount($first_stock->getPriceAfterDiscount() - $ezzicoDiscount) }}</span>
                                        <del class="text-content fs-6" id="without_discount_price">
                                            {{ getFormattedAmount($first_stock->unit_price) }}
                                        </del>
                                        <span class="offer theme-color fs-6" id="discount_info"> {{ $first_stock->getDiscountInfo() }} </span>
                                    @else
                                        @php
                                            $ezzicoDiscount = $product->getEzzicoDiscount($first_stock->unit_price);
                                        @endphp
                                        <span id="price">{{ getFormattedAmount($first_stock->unit_price - $ezzicoDiscount) }}</span>

                                        @if($ezzicoDiscount > 0)
                                            <del class="text-content fs-6" id="without_discount_price">
                                                {{ getFormattedAmount($first_stock->unit_price) }}
                                            </del>
                                            <span class="offer theme-color fs-6" id="discount_info"> {{ $first_stock->getDiscountInfo() }} </span>
                                        @endif
                                    @endif
                                </h3>



                                <input type="hidden" name="unit_price" class="unit_price" value="{{ $first_stock->unit_price }}">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="ezzico_discount" class="ezzico_discount" value="{{ $ezzicoDiscount }}">

                                <form class="product-form" action="javascript:void(0)">
                                    <div class="product-package">

                                        @if (isset($product->colors) && count($product->colors) > 0)
                                            <div class="product-title">
                                                <h4>Color </h4>
                                            </div>

                                            <ul class="color circle select-package">
                                                @foreach ($product->colors as $key => $color)
                                                    <li class="form-check">
                                                        <input type="radio" name="color" value="{{ $color->id }}"
                                                        @if($color->id == explode('-',$first_stock->variant_ids)[$variant_index] ) checked @endif
                                                            class="form-check-input"
                                                            onclick="changeAttribute({{ $product->id }})"
                                                            id="color{{ $key }}">
                                                        <label class="form-check-label" for="color{{ $key }}">
                                                            <span style="background-color:{{ $color->color_code }}"></span>
                                                        </label>
                                                    </li>
                                                @endforeach

                                            </ul>
                                            @php $variant_index = 1; @endphp
                                        @endif

                                        @if (isset($attributes) && count($attributes) > 0)
                                            @foreach ($attributes as $index => $attribute)
                                                @php $check=true; @endphp
                                                <div class="product-title">
                                                    <h4>{{ $attribute->name }} </h4>
                                                </div>

                                                <ul class="rectangle select-package">
                                                    @foreach ($attribute->attributeValues as $key => $attributeValue)
                                                        @if (in_array($attributeValue->id, json_decode($product->selected_variants_ids)))
                                                            @php $name = $attribute->id.'_attribute';@endphp
                                                            <li class="form-check">
                                                                <input class="form-check-input attribute" type="radio"
                                                                @if($attributeValue->id == explode('-',$first_stock->variant_ids)[$index+$variant_index] ) checked @endif
                                                                    onclick="changeAttribute({{ $product->id }})"
                                                                    name="attribute[{{ $index }}]"
                                                                    id="{{ $name }}_{{ $attributeValue->id }}"
                                                                    value="{{ $attributeValue->id }}">
                                                                <label class="form-check-label"
                                                                    for="{{ $name }}_{{ $attributeValue->id }}">
                                                                    <span>{{ $attributeValue->value }}</span>
                                                                </label>
                                                            </li>
                                                            @php $check=false; @endphp
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @endforeach
                                        @endif

                                        <div
                                            class="quantity-section d-flex align-items-center justify-content-center justify-content-md-start gap-3 mt-2">
                                            <div class="product-title">
                                                <h4>Quantity</h4>
                                            </div>

                                            <ul class="quantity circle select-package">
                                                <li>
                                                    <button class="quantity-item minus"><i class="fa fa-minus"></i></button>
                                                </li>
                                                <li>
                                                    <input class="quantity-item qty-input product_quantity"
                                                        id="product_quantity" type="number" value="1" min="1"
                                                        max="{{ $first_stock->current_stock }}">
                                                </li>
                                                <li>
                                                    <button class="quantity-item plus"><i class="fa fa-plus"></i></button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex align-items-center justify-content-center justify-content-md-start gap-4">
                                        <button {{ $first_stock->current_stock > 0 ? '' : 'disabled' }}
                                            class="btn theme-bg-color mt-sm-4 btn-md text-white py-2 px-2 fw-300 btn-add-to-cart">
                                            <i data-feather="shopping-cart"></i>
                                            <span class="ms-1">Add To Cart</span>
                                        </button>
                                        <button {{ $first_stock->current_stock > 0 ? '' : 'disabled' }}
                                            class="btn bg-dark text-white mt-sm-4 btn-md py-2 fw-300">
                                            Buy Now
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-2 col-xl-3 col-lg-5 d-none d-lg-block">
                    <div class="right-sidebar-box">
                        <div class="service-section">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="service-contain">

                                        @if(count($product->productServices) > 0)
                                            @foreach($product->productServices as $service)
                                                <div class="service-box">
                                                    <div class="service-image">
                                                        <i class="fa-solid fa-layer-group"></i>
                                                        {{-- <img src="{{ asset('frontend/svg/product.svg') }}"
                                                            class="blur-up lazyload" alt=""> --}}
                                                    </div>

                                                    <div class="service-detail">
                                                        <h5>{{ $service->getTranslation('title') }}</h5>
                                                        <span>{{ $service->getTranslation('sub_title') }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                        @if (false)
                                        <div class="service-box">
                                            <div class="">
                                                <span>Sold by</span>
                                                <h3>{{ $product->seller->store->getTranslation('store_name') }}</h3>
                                            </div>

                                            <div class="service-detail">
                                                <a href="{{ route('public.seller.seller_shop', $product->seller->store->slug) }}">Visit Store</a>
                                            </div>
                                        </div>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="product-section-box">
                    <div class="row">
                        <div class="col-12 col-lg-2">
                            <div class="product-details-nav">
                                <ul class="nav nav-tabs custom-nav flex-lg-column justify-content-lg-center"
                                    id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active text-start" id="description-tab"
                                            data-bs-toggle="tab" data-bs-target="#description" type="button"
                                            role="tab">Description</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link text-start" id="review-tab" data-bs-toggle="tab"
                                            data-bs-target="#review" type="button" role="tab">Review</button>
                                    </li>
                                    {{-- <li class="nav-item" role="presentation">
                                        <button class="nav-link text-start" id="info-tab" data-bs-toggle="tab"
                                            data-bs-target="#info" type="button" role="tab">warranty</button>
                                    </li> --}}

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link text-start" id="qa-tab" data-bs-toggle="tab"
                                            data-bs-target="#qa" type="button" role="tab">Question & Answer</button>
                                    </li>
                                    {{-- <li class="nav-item" role="presentation">
                                        <button class="nav-link text-start" id="care-tab" data-bs-toggle="tab"
                                            data-bs-target="#care" type="button" role="tab">Store Details</button>
                                    </li> --}}
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-lg-10">
                            <div class="product-details px-4">
                                <div class="tab-content custom-tab" id="myTabContent">
                                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                                        @include('public.pages.product.partials.description')
                                    </div>

                                    <div class="tab-pane fade" id="review" role="tabpanel">
                                        @include('public.pages.product.partials.review')
                                    </div>

                                    {{-- <div class="tab-pane fade" id="info" role="tabpanel">
                                        @include('public.pages.product.partials.warranty')
                                    </div> --}}

                                    <div class="tab-pane fade" id="qa" role="tabpanel">
                                        @include('public.pages.product.partials.questionAnswer')
                                    </div>

                                    {{-- <div class="tab-pane fade" id="care" role="tabpanel">
                                        @include('public.pages.product.partials.store_details')
                                    </div> --}}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Product Left Sidebar End -->

        <!-- Recent Products Section Start -->
        <section class="flashSale-section">
        <div class="container-fluid-lg py-4">
            <div>
                <h2 class="text-md-center text-start">Recent Products</h2>
            </div>
            <div class="slider-7_1 arrow-slider img-slider">
                @forelse($recent_products??[] as $key => $product)
                        @include('public.pages.product.product')
                @empty
                <div style="width: 100%; height: 100vh;text-align: center;">
                    <img src="{{ Vite::asset(Enum::NO_DATA_IMAGE_PATH) }}" class="img-fluid blur-up lazyload" alt="">
                        <h2 class="mt-3"> No Data Found </h2>
                </div>
                @endforelse

            </div>
        </div>
    </section>
    <!-- Recent Products Section End -->

    <!-- Related Product Section Start -->
    <section class="flashSale-section">
        <div class="container-fluid-lg py-4">
            <div>
                <h2 class="text-md-center text-start">Related Product</h2>
            </div>
            <div class="slider-7_1 arrow-slider img-slider">
                @forelse($related_products??[] as $key => $product)
                        @include('public.pages.product.product')
                @empty
                <div style="width: 100%; height: 100vh;text-align: center;">
                    <img src="{{ Vite::asset(Enum::NO_DATA_IMAGE_PATH) }}" class="img-fluid blur-up lazyload" alt="">
                        <h2 class="mt-3"> No Data Found </h2>
                </div>
                @endforelse

            </div>
        </div>
    </section>
    <!-- Related Product Section End -->

    <!-- Related Product Section Start -->
    @if (false)
    <section class="flashSale-section">
        <div class="container-fluid-lg py-4">
            <div>
                <h2 class="text-md-center text-start">Seller Top Products</h2>
            </div>
            <div class="slider-7_1 arrow-slider img-slider">
                @forelse($top_products??[] as $key => $product)
                        @include('public.pages.product.product')
                @empty
                <div style="width: 100%; height: 100vh;text-align: center;">
                    <img src="{{ Vite::asset(Enum::NO_DATA_IMAGE_PATH) }}" class="img-fluid blur-up lazyload" alt="">
                        <h2 class="mt-3"> No Data Found </h2>
                </div>
                @endforelse

            </div>
        </div>
    </section>
    @endif

    <!-- Related Product Section End -->
@endsection
@include('public.assets.zoomer')

@push('scripts')
    @vite('resources/frontend_assets/js/pages/product/show.js')

    <script>
        const path = location.pathname.replace('/show', '');

        var offset = 0;
        var baseUrl = "{{ url('/') }}";

        function loadMoreQA() {
            $.ajax({
                url: `${path}/load-more-question`,
                method: 'GET',
                data: {
                    offset: offset
                },
                success: function(response) {
                    if (response.length > 0) {
                        // Create an array of HTML div elements
                        let divs = response.map(question_answer =>
                            `<div class="py-3 border-1 border-top rounded-3">
                            <div class="people-box">
                                <div>
                                    <div class="people-image people-text">
                                        ${question_answer.parent.customer.avatar ?
                                            `<img alt="user" class="w-100 h-100 rounded-circle" src="${ baseUrl + '/' + question_answer.parent.customer.avatar}">`
                                            :
                                           ' <img alt="user" class="w-100 h-100 rounded-circle" src="{{ Vite::asset(Enum::NO_AVATAR_PATH) }}">'
                                        }
                                    </div>
                                </div>
                                <div class="people-comment">
                                    <div class="name">${question_answer.parent.customer?.full_name}<span class="text-secondary ms-2" style="font-size: 10px">${question_answer.parent.created_at ? moment(question_answer.parent.created_at).format('DD-MM-YYYY'): ''}</span></div>
                                    <div>
                                        <p class="m-0 text-secondary">${question_answer.parent.comment}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="people-box">
                                    <div>
                                        <div class="people-image people-text">
                                            ${question_answer.seller.avatar ?
                                                `<img alt="user" class="w-100 h-100 rounded-circle" src="${ baseUrl + '/' + question_answer.seller.avatar}">`
                                                :
                                            ' <img alt="user" class="w-100 h-100 rounded-circle" src="{{ Vite::asset(Enum::NO_AVATAR_PATH) }}">'
                                            }
                                        </div>
                                    </div>
                                    <div class="people-comment">
                                        <div class="name">${question_answer.seller?.full_name}<span class="text-secondary ms-2" style="font-size: 10px">${question_answer.created_at ? moment(question_answer.created_at).format('DD-MM-YYYY'): ''}</span></div>
                                        <div>
                                            <p class="m-0 text-secondary">${question_answer.comment}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`
                        );

                        // Join the array of HTML div elements into a single string
                        let div = divs.join('');

                        // Append the generated HTML to the question-container
                        $('#question-container').append(div);

                        offset += 4;
                    } else {
                        $('#question-container').append(
                            '<h5 class="text-secondary">No question and answer is found.</h5>');
                        $('#load-more-btn').hide();
                    }
                }
            });
        }

        $('#load-more-btn').click(function() {
            loadMoreQA();
        });

        $(document).ready(function() {
            loadMoreQA();
        });
    </script>
@endpush


@push('style')
    <style>
        .thumbnail-image {
            width: 100%;
            height: 100%;
        }
    </style>
@endpush
