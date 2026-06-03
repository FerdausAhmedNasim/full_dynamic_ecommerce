@extends('public.layout.master')
@section('title', 'Product Details')
@php
    $ogUrl = route('public.product.show', $product->slug);
@endphp
@section('og_title', $product->getTranslation('title'))
@section('og_url', $ogUrl)
@section('og_image', $product->getThumbnailImage())
@section('canonical', $ogUrl)
@section('og_description', $product->getTranslation('short_description') ?? 'Mukto Shop BD is the biggest online shopping platform in Bangladesh, offering a wide range of products including fashion, electronics, home appliances, and more.')

@section('content')
@php
use App\Library\Enum;
use Illuminate\Support\Facades\Vite;
$variant_index = 0;
$ezzicoDiscount = 0;
@endphp
<!-- ======= Breadcrumbs ======= -->
{!! \App\Library\Html::breadcrumbsSection('Product Details','','', 'product', $product??'') !!}
<!-- End Breadcrumbs -->
<!-- Product Left Sidebar Start -->
<section class="product-section pt-3">
    <div class="container-fluid-lg">
        <div class="row">
            <div class=" col-xl-9 col-lg-7">
                <div class="row g-4">
                    <div class="col-xl-6">
                        <div class="product-left-box">
                            <div class="row g-2">
                                <div class="col-xxl-10 col-lg-12 col-md-10 order-xxl-2 order-lg-1 order-md-2">
                                    <div class="product-main-2 no-arrow">
                                        @php
                                            $productImages = $product->attachments->whereIn('for', ['thumbnail', 'gallery']);
                                            $productStockImages = $product->productStocks->flatMap(function($productStock) {
                                                return $productStock->load('attachments')->attachments->whereIn('for', ['variant']);
                                            });

                                            $attachments = $productImages->concat($productStockImages)->sortByDesc('for');
                                        @endphp
                                        @foreach ($attachments as $key => $attachment)
                                        <div>
                                            <div class="slider-image">
                                                <img data-src="{{ $attachment->getAttachment() }}" id="img-{{$key+1}}"
                                                    data-zoom-image="{{ $attachment->getAttachment() }}" alt=""
                                                    class="img-fluid image_zoom_cls-{{ $key }} blur-up lazyload thumbnail-image">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @if ($product->has_variant && count($product->productStocks) > 1 || count($product->colors) > 1)
                                    <input type="hidden" value="Please select color and size" id="type_text">
                                @endif

                                <div class="col-xxl-2 col-lg-12 col-md-2 order-xxl-1 order-lg-2 order-md-1" id="gallery-image-div">
                                    <div class="left-slider-image-2 left-slider no-arrow slick-top">
                                        @foreach ($attachments as $key => $galleryAttachment)
                                        <div>
                                            <div class="slider-image">
                                                <img data-src="{{ $galleryAttachment->getAttachment() }}" id="img-{{$key+1}}"
                                                    data-zoom-image="{{ $galleryAttachment->getAttachment() }}"
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
                            <div class="d-flex justify-content-between gap-1">
                                <h2 class="name">{{ $product->getTranslation('title') }}</h2>
                                <div class="d-flex align-items-start justify-content-end gap-2">
                                    <div class="media-section position-relative">
                                        <div class="share-icon">
                                            <i class="fa fa-share-alt"></i>
                                        </div>
                                        <div class="media-group">
                                            <ul class="social-share-list">
                                                {!! $button_component !!}
                                                <button id="copyLinkButton" class="copy-link-btn"><i class="fa fa-copy"></i></button>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <button
                                            class="share-icon wishlist btn-wishlist {{$product->wishlist()->where('user_id', authUser()?->id)->first() ? 'text-danger' : '' }}">
                                            <i class="iconly-Heart icli"></i>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="product_id" class="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="user_id" class="user_id" value="{{ authUser()?->id }}">
                                <input type="hidden" name="product_slug" class="product_slug"
                                    value="{{ $product->slug }}">
                            </div>
                            <div class="price-rating mb-2">
                                <div class="product-rating custom-rate">
                                    {!! \App\Library\Html::rating($overallRetting) !!}
                                    <span class="review">({{ $product->productReview(true)->count() }}) Customer
                                        Review</span>
                                </div>
                            </div>

                            <div class="brand pb-3">
                                <strong>BRAND :</strong>
                                @if (isset($product->brand))
                                <span class="brand-title">{{ $product?->brand?->getTranslation('title') }}</span>
                                @else
                                <span class="brand-title">No Brand</span>
                                @endif
                            </div>

                            <div id="stock_badge">
                                {!! \App\Library\Html::StockBadge($first_stock->current_stock,
                                $product->stock_visibility) !!}
                            </div>
                            <div class="theme-color product-price mt-3">
                                @if ($product->has_discount)
                                    @php
                                    // $ezzicoDiscount = $product->getEzzicoDiscount($first_stock->getPriceAfterDiscount());
                                    $ezzicoDiscount = $product->getEzzicoDiscount($first_stock->unit_price);
                                    @endphp

                                    <h4 class="theme-color" id="price">{{ getFormattedAmount($first_stock->getPriceAfterDiscount() -
                                        $ezzicoDiscount) }}</h4>
                                    <del class="text-content" id="without_discount_price">
                                        {{ getFormattedAmount($first_stock->unit_price) }}
                                    </del>
                                    <span class="offer theme-color" id="discount_info"> {{
                                        $first_stock->getDiscountInfo() }} </span>
                                @else
                                    @php
                                    $ezzicoDiscount = $product->getEzzicoDiscount($first_stock->unit_price);
                                    @endphp
                                    <h4 class="theme-color" id="price_ezzico">{{ getFormattedAmount($first_stock->unit_price - $ezzicoDiscount)
                                        }}</h4>

                                    @if($ezzicoDiscount > 0)
                                        <del class="text-content" id="without_discount_price_ezzico">
                                            {{ getFormattedAmount($first_stock->unit_price) }}
                                        </del>
                                        <span class="offer theme-color" id="discount_info_ezzico"> {{
                                        $first_stock->getDiscountInfo() }} </span>
                                    @endif
                                @endif
                            </div>

                            <input type="hidden" name="unit_price" class="unit_price"
                                value="{{ $first_stock->unit_price }}">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="ezzico_discount" class="ezzico_discount"
                                value="{{ $ezzicoDiscount }}">

                            <form class="product-form" action="javascript:void(0)">
                                <div class="product-package">

                                    @if (isset($product->colors) && count($product->colors) > 0)
                                    <div class="color-title">
                                        <h4>Color </h4>
                                    </div>

                                    <ul class="color circle select-package">
                                        @foreach ($product->colors as $key => $color)
                                        <li class="form-check">
                                            <input type="radio" name="color" value="{{ $color->id }}" @if($color->id ==
                                            explode('-',$first_stock->variant_ids)[$variant_index] ) checked @endif
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
                                        @if (in_array($attributeValue->id,
                                        json_decode($product->selected_variants_ids)))
                                        @php $name = $attribute->id.'_attribute';@endphp
                                        <li class="form-check">
                                            <input class="form-check-input attribute" type="radio"
                                                @if($attributeValue->id ==
                                            explode('-',$first_stock->variant_ids)[$index+$variant_index] ) checked
                                            @endif
                                            onclick="changeAttribute({{ $product->id }})"
                                            name="attribute[{{ $index }}]"
                                            id="{{ $name }}_{{ $attributeValue->id }}"
                                            value="{{ $attributeValue->id }}">
                                            <label class="form-check-label" for="{{ $name }}_{{ $attributeValue->id }}">
                                                <span>{{ $attributeValue->value }}</span>
                                            </label>
                                        </li>
                                        @php $check=false; @endphp
                                        @endif
                                        @endforeach
                                    </ul>

                                    @endforeach
                                    @endif

                                    <div class="quantity-section mt-2">
                                        <div class="quantity-title">
                                            <h4>Quantity :</h4>
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
                                @if ($product->has_variant && count($product->productStocks) > 1 || count($product->colors) > 1)
                                <div class="animated-filed">
                                    <div id="circle"></div>
                                    <div class="typing-text"  id="typing-text"></div>
                                </div>
                                @endif
                                <div
                                    class="d-flex align-items-center justify-contentmd-center justify-content-md-start gap-4 mt-4">
                                    <button {{ $first_stock->current_stock > 0 ? '' : 'disabled' }} class="btn
                                        theme-color-1 text-white mt-sm-4 btn-md py-2 px-5 fw-300" id="buyNow">
                                        Buy Now
                                    </button>
                                    <button {{ $first_stock->current_stock > 0 ? '' : 'disabled' }}
                                        class="btn theme-bg-color mt-sm-4 btn-md text-white py-2 px-5 fw-300
                                        btn-add-to-cart" id="addToCart">
                                        <span class="ms-1">Add To Cart</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-5">
                <div class="right-sidebar-box mt-3">
                    <div class="service-section">
                        <div class="row g-3">
                            <div class="col-12 mt-3 mt-md-0">
                                <div class="service-contain">
                                    <strong class="service-title">Delivery Information</strong>

                                    <div class="service-box">
                                        <div class="service-image">
                                            <i class="fa-solid fa-layer-group"></i>
                                        </div>
                                        <div class="service-detail w-100">
                                            <div class="d-flex justify-content-between">
                                                <div class="service-title">
                                                    {{-- <h5>{{$product->productDetails?->shipping_fee ? "Standard Delivery"
                                                        : "Free Delivery" }}</h5> --}}
                                                    <p class="m-0">
                                                        Standard Delivery Time: {{$product->productDetails?->estimated_shipping_days}} Days</p>
                                                </div>
                                                {{-- <p class="m-0">{{$product->productDetails?->shipping_fee ?
                                                    $product->productDetails?->shipping_fee : "Free"}}</p> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="service-box">
                                        <div class="service-image">
                                            <i class="fa-solid fa-layer-group"></i>
                                        </div>
                                        <div class="service-detail w-100">
                                            <div class="d-flex justify-content-between">
                                                <div class="service-title">
                                                    {{-- <p>{{$product->cash_on_delivery ? "Cash on Delivery Available" : "Cash
                                                        on Delivery not Available"}}</p> --}}
                                                    <p class="m-0">Cash on Delivery Available</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="service-box">
                                        <div class="service-image">
                                            <i class="fa-solid fa-layer-group"></i>
                                        </div>
                                        <div class="service-detail w-100">
                                            <div class="d-flex justify-content-between">
                                                <div class="service-title">
                                                    <p class="m-0">{{$product->refundable ? "Refundable is Available" : "Refundable is
                                                        not Available"}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <strong class="service-title">Service Information</strong>
                                    @if(count($product->productServices) > 0)
                                    @foreach($product->productServices as $service)
                                    <div class="service-box  border-bottom border-1 border-light">
                                        <div class="service-image">
                                            <i class="fa-solid fa-layer-group"></i>
                                        </div>

                                        <div class="service-detail">
                                            <p class="m-0">{{ $service->getTranslation('title') }}</p>
                                            <span>{{ $service->getTranslation('sub_title') }}</span>
                                        </div>
                                    </div>
                                    @endforeach
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
                            <ul class="nav nav-tabs custom-nav flex-lg-column justify-content-lg-center" id="myTab"
                                role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active text-start" id="description-tab" data-bs-toggle="tab"
                                        data-bs-target="#description" type="button" role="tab">Description</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link text-start" id="review-tab" data-bs-toggle="tab"
                                        data-bs-target="#review" type="button" role="tab">Review</button>
                                </li>
                                {{-- <li class="nav-item" role="presentation">
                                    <button class="nav-link text-start" id="info-tab" data-bs-toggle="tab"
                                        data-bs-target="#info" type="button" role="tab">Warranty</button>
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
{{-- <section class="flashSale-section">
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
</section> --}}
<!-- Related Product Section End -->
@include('public.assets.imageModal')
@include('public.assets.zoomer')
@endsection

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
                                    <svg viewBox="115 120 33 35.34" width="25" height="25" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:bx="https://boxy-svg.com">
                                        <g>
                                            <path
                                                style="stroke: rgb(53, 53, 53); transform-box: fill-box; transform-origin: 50% 50%; fill: rgb(7, 157, 223);"
                                                d="M 118 120 H 142 A 6 6 0 0 1 148 126 V 150 H 118 V 120 Z"
                                                bx:shape="rect 118 120 30 30 0 6 0 0 1@62db7f42" />
                                        </g>
                                        <g>
                                            <polyline style="stroke: rgb(27, 24, 24); fill: rgb(7, 157, 223);"
                                                points="118.824 141 115 155.34 126.472 147.692" />
                                        </g>
                                        <g>
                                            <text
                                                style="fill: rgb(255, 255, 255); font-family: Roboto; font-size: 22px; white-space: pre;"
                                                x="126.195" y="142.674">Q</text>
                                        </g>
                                        </svg>
                                </div>
                            </div>
                            <div class="people-comment">
                                <div class="name">${question_answer?.customer?.full_name}<span class="text-secondary ms-2" style="font-size: 10px">${question_answer?.created_at ? moment(question_answer?.created_at).format('DD-MM-YYYY h:mm A'): ''}</span></div>
                                <div>
                                    <p class="m-0 text-secondary">${question_answer?.comment}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="people-box">
                                <div>
                                    <div class="people-image people-text">
                                        <svg viewBox="115 120 33 35.34" width="25" height="25"
                                            xmlns="http://www.w3.org/2000/svg" xmlns:bx="https://boxy-svg.com">
                                            <g>
                                                <path
                                                    style="stroke: rgb(53, 53, 53); fill: rgb(102, 102, 102); transform-box: fill-box; transform-origin: 50% 50%;"
                                                    d="M 118 120 H 142 A 6 6 0 0 1 148 126 V 150 H 118 V 120 Z"
                                                    bx:shape="rect 118 120 30 30 0 6 0 0 1@62db7f42" />
                                            </g>
                                            <g>
                                                <polyline style="stroke: rgb(27, 24, 24); fill: rgb(102, 102, 102);"
                                                    points="118.824 141 115 155.34 126.472 147.692" />
                                            </g>
                                            <g>
                                                <text
                                                    style="fill: rgb(255, 255, 255); font-family: Roboto; font-size: 22px; white-space: pre;"
                                                    x="126.195" y="142.674">A</text>
                                            </g>
                                        </svg>
                                    </div>
                                </div>

                                    <div class="people-comment">
                                        <div class="name">${question_answer?.children_question?.seller?.full_name}<span class="text-secondary ms-2" style="font-size: 10px">${question_answer?.children_question?.created_at ? moment(question_answer?.children_question?.created_at).format('DD-MM-YYYY h:mm A'): ''}</span></div>
                                        <div>
                                            <p class="m-0 text-secondary">${question_answer?.children_question?.comment}</p>
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

                    if (response.length < 4) {
                        $('#load-more-btn').hide();
                    }
                    offset += 4;
                } else {
                    $('#question-container').append(
                        '<h5 class="text-secondary">Customer Question and Answer are not available</h5>');
                    $('#load-more-btn').hide();
                }
            }
        });
    }

    $('#load-more-btn').click(function() {
        loadMoreQA();
    });

    // $(document).ready(function() {
    //     loadMoreQA();
    // });


    // Store Question
    $(document).on("click",".question-btn",function() {
        var btn = $(this);
        var comment = btn.closest('.qa-box').find('.content').val();
        var productId = btn.closest('.qa-box').find('.product_id').val();
        var userId = btn.closest('.qa-box').find('.customer_id').val();

        $.ajax({
            url: '/products/questionStore',
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                comment: comment,
                customer_id: userId,
                product_id: productId
            },
            success: function (response) {

                var newQuestionHTML = `
                <div class="py-3 border-1 border-top rounded-3">
                    <div class="people-box">
                        <div>
                            <div class="people-image people-text">
                                <svg viewBox="115 120 33 35.34" width="25" height="25" xmlns="http://www.w3.org/2000/svg"
                                xmlns:bx="https://boxy-svg.com">
                                <g>
                                    <path
                                        style="stroke: rgb(53, 53, 53); transform-box: fill-box; transform-origin: 50% 50%; fill: rgb(7, 157, 223);"
                                        d="M 118 120 H 142 A 6 6 0 0 1 148 126 V 150 H 118 V 120 Z"
                                        bx:shape="rect 118 120 30 30 0 6 0 0 1@62db7f42" />
                                </g>
                                <g>
                                    <polyline style="stroke: rgb(27, 24, 24); fill: rgb(7, 157, 223);"
                                        points="118.824 141 115 155.34 126.472 147.692" />
                                </g>
                                <g>
                                    <text
                                        style="fill: rgb(255, 255, 255); font-family: Roboto; font-size: 22px; white-space: pre;"
                                        x="126.195" y="142.674">Q</text>
                                </g>
                            </svg>
                            </div>
                        </div>
                        <div class="people-comment">
                            <div class="people-name">
                                <div class="name">${response?.customer?.full_name}<span class="text-secondary ms-2" style="font-size: 10px">${moment(response?.created_at).format('DD-MM-YYYY h:mm A')}</span></div>
                            </div>
                            <div class="reply">
                                <p class="m-0 text-secondary">${response?.comment}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                       '<span class="text-secondary">No answer yet</span>'
                    </div>
                </div>
                `;
            $(".customer-question").prepend(newQuestionHTML);
            btn.closest('.qa-box').find('.content').val('');
            var comment = btn.closest('.qa-box').find('h4').html("My Questions");
            },
            error: function (xhr, status, error) {
                if (xhr.responseText) {
                }
            }
        });
    });

    function changeAttribute(product_id) {
        var attributes = $(".product-form").serializeArray();

        $.ajax({
            url: BASE_URL + "/products/variant",
            method: 'get',
            data: {
                product_id: product_id,
                attributes: attributes,
            },
            dataType: 'json',
            success: function (response) {
                if (response !== '') {
                    if (response.current_stock > 0) {
                        $('#addToCart').attr('disabled', false)
                        $('#buyNow').attr('disabled', false)
                    } else {
                        $('#addToCart').attr('disabled', true)
                        $('#buyNow').attr('disabled', true)
                    }

                    selectedImage = response?.image;

                    if (selectedImage) {
                        $('.slick-slide.slick-current.slick-active img').attr('src', selectedImage);
                        $('.slick-slide.slick-current.slick-active img').attr('data-zoom-image', selectedImage);
                        $('.zoomWindow').css('background-image', 'url(' + selectedImage + ')');
                    }

                    $("#stock_badge").html(response.stock_badge);
                    $('#product_quantity').prop('max', response.current_stock);
                    $('#product_quantity').val(1);

                    if (parseInt(response.has_discount) === 1) {
                        $("#price").html(formatPrice(response.discounted_price));
                        $("#without_discount_price").html(response.price);
                        $("#discount_info").html(response.discounted_info);
                    }
                    else if (parseInt(response.has_ezzico_discount) === 1) {
                        alert('sdfd');
                        $("#price_ezzico").html(formatPrice(response.discounted_price));
                        $("#without_discount_price_ezzico").html(response.price);
                        $("#discount_info_ezzico").html(response.discounted_info);
                    }
                    else {
                        $("#price_ezzico").html(response.price);
                    }

                    $(".unit_price").val(response.price.replace(/[$,৳,€,£,₹]/g, ''));
                }

            }
        });
    };

    $(document).ready(function() {
    const text = $('#type_text').val();
    const speed = 100;
    const delay = 2000;
    let index = 0;

    function animateCircle() {
        const circle = $('#circle');
        const animatedFiled = $('.animated-filed');

        const animatedFiledOffset = animatedFiled.offset();
        const animatedFiledHeight = animatedFiled.height();
        const animatedFiledWidth = animatedFiled.width();

        const interval = setInterval(function() {
            let circleTop = 10;
            
            setTimeout(() => {
                if (circle.offset().top > animatedFiledHeight) {
                    animatedFiled.addClass('active');
                    animatedFiled.css({
                        'background-color': 'var(--general-color)',
                        'color': 'var(--primary-color) !important',
                        'border': '1px solid var(--primary-color)',
                    });

                    circle.css({
                        'background-color': 'transparent',
                    });

                    clearInterval(interval);
                }
            }, 1700);
            
            circle.css('top', circleTop + 5 + 'px');
        }, 800);
    }

    function type() {
        if (index < text.length) {
            const char = text.charAt(index);
            let charSpan;

            // Create a span for each character
            if (char === ' ') {
                // Apply a margin for space
                charSpan = $('<span class="typing-char" style="margin-right: 10px;">' + char + '</span>');
            } else {
                // Assign a color to the character
                charSpan = $('<span class="typing-char" style="color: var(--general-color);">' + char + '</span>');
            }

            $('#typing-text').append(charSpan);

            setTimeout(() => {
                charSpan.addClass('falling');
            }, speed * index);
            
            index++;
            setTimeout(type, speed);
        }else {
            setTimeout(() => {
                $('#typing-text').empty();
                index = 0;
                setTimeout(type, delay);
            }, delay);
        }
    }

    if (text) {
        type();
        animateCircle();
    }
});

    document.getElementById("copyLinkButton").addEventListener("click", function() {
        const tempInput = document.createElement("input");
        document.querySelector('.media-group').appendChild(tempInput);
        tempInput.value = location.href;
        tempInput.select();
        document.execCommand("copy");
        document.querySelector('.media-group').removeChild(tempInput);
        
        notify("Link copied to clipboard!");
    });

</script>
@endpush


@push('styles')
<style>
    .animated-filed {
        height: 50px;
        width: 460px;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 5px;
        transition: all 0.3s ease;
        position: absolute;
        right: -12px;
        bottom: 85px;
        background-color: var(--primary-color);
    }

    .typing-char {
        opacity: 0;
        position: relative;
        display: inline-block;
        animation: typingEffect 0.25s ease forwards, fallDown 1s ease-in-out forwards;
    }

    .animated-filed.active .typing-char {
        color: var(--primary-color) !important;
    }

    #circle {
        position: absolute;
        top: -200px;
        left: 50%;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: var(--primary-color);
        transition: all 2s ease-in-out;
    }

    @keyframes typingEffect {
        0% {
            opacity: 0;
            transform: scale(0) translateY(20px); /* Start from small and shifted */
        }
        100% {
            opacity: 1;
            transform: scale(1) translateY(0); /* End in normal position */
        }
    }

    @keyframes fallDown {
        0% {
            opacity: 0;
            transform: translateY(-50px); /* Start from above */
        }
        100% {
            opacity: 1;
            transform: translateY(-2px); /* End in the final position with downward movement */
        }
    }

    .typing-text {
        font-size: 26px;
        color: #333;
        display: inline-block;
        font-weight: 600;
    }
    .copy-link-btn{
        height: 40px;
        display: flex;
        align-items: center;
        text-align: center;
        font-size: 20px;
        transition: all 0.5s ease;
        background-color: #ffffff;
        color: #53c309;
        padding: 8px 12px;
    }

    @media (max-width: 768px) {
        .animated-filed {
            position: static;
            width: 100%;
            margin-top: 16px;
        }
        .typing-text {
            font-size: 20px;
        }

        #circle {
           opacity: 0;
        }
    }
</style>
@endpush
