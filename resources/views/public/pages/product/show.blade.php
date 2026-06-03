@extends('public.layout.master')
@section('title', 'Product Details')

@section('content')
<!-- ======= Breadcrumbs ======= -->
{!! \App\Library\Html::breadcrumbsSection('Product Details') !!}
<!-- End Breadcrumbs -->
<!-- Product Left Sidebar Start -->
<section class="product-section pt-3">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-xxl-10 col-xl-9 col-lg-7 wow fadeInUp">
                <div class="row g-4">
                    <div class="col-xl-6 wow fadeInUp">
                        <div class="product-left-box">
                            <div class="row g-2">
                                <div class="col-xxl-10 col-lg-12 col-md-10 order-xxl-2 order-lg-1 order-md-2">
                                    <div class="product-main-2 no-arrow">
                                        @foreach($product->attachments as $key => $attachment)
                                        <div>
                                            <div class="slider-image">
                                                <img src="{{ $attachment->getAttachment() }}" id="img-1"
                                                    data-zoom-image="{{ $attachment->getAttachment() }}" class="
                                                        img-fluid image_zoom_cls-{{$key}} w-100 h-100 blur-up lazyload"
                                                    alt="">
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>

                                <div class="col-xxl-2 col-lg-12 col-md-2 order-xxl-1 order-lg-2 order-md-1">
                                    <div class="left-slider-image-2 left-slider no-arrow slick-top">
                                        @foreach($product?->attachments as $attachment)
                                        <div>
                                            <div class="slider-image">
                                                <img src="{{ $attachment->getAttachment() }}" id="img-1"
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

                    <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="right-box-contain">
                            <div class="d-flex justify-content-between">
                                <h2 class="name">{{ $product->getTranslation('title') }}</h2>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="media-section position-relative">
                                        <div class="share-icon">
                                            <i class="fa fa-share-alt"></i>
                                        </div>
                                        <div class="media-group">
                                            <p class="text-nowrap m-0">Share Via : </p>
                                            <ul class="social-share-list">
                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <i class="fa-brands fa-facebook-f"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <i class="fa-brands fa-twitter"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)">
                                                        <i class="fa-brands fa-linkedin-in"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="share-icon">
                                            <i class="fa fa-heart"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="price-rating">
                                <div class="product-rating custom-rate">
                                    <ul class="rating">
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star" class="fill"></i>
                                        </li>
                                        <li>
                                            <i data-feather="star"></i>
                                        </li>
                                    </ul>
                                    <span class="review">23 Customer Review</span>
                                </div>
                            </div>

                            <div class="mt-2">
                                <strong>Brand :</strong>
                                {{-- <span>{{ $product?->brand?->getTranslation('title') }}</span> --}}
                            </div>
                            <h3 class="theme-color price mt-4">{{ $product->getPriceAfterDiscount() }}
                                <del class="text-content fs-6">{{ getFormattedAmount($product->unit_price) }} </del>
                                <span class="offer theme-color fs-6 ms-1"> {{ $product->getDiscountInfo() }} </span></h3>

                            <form class="product-form">
                                <div class="product-package">

                                    @if(isset($product->colors) && count($product->colors) > 0)
                                    <div class="product-title">
                                        <h4>Color </h4>
                                    </div>

                                    <ul class="color circle select-package">
                                        @foreach($product->colors as $key => $color)
                                        <li class="form-check">
                                            <input type="radio" name="color" value="{{ $color->id }}"
                                                class="form-check-input" onclick="changeAttribute()" id="color{{$key}}">
                                            <label class="form-check-label" for="color{{$key}}">
                                                <span style="background-color:{{$color->color_code}}"></span>
                                            </label>
                                        </li>
                                        @endforeach

                                    </ul>
                                    @endif

                                    @if(isset($attributes) && count($attributes) >0 )
                                    @foreach($attributes as $index => $attribute)
                                    <div class="product-title">
                                        <h4>{{ $attribute->name }} </h4>
                                    </div>

                                    <ul class="rectangle select-package">
                                        @foreach($attribute->attributeValues as $key => $attributeValue)
                                        @if(in_array($attributeValue->id, json_decode($product->selected_variants_ids)))
                                        @php $name = $attribute->id.'_attribute'@endphp
                                        <li class="form-check">
                                            <input class="form-check-input attribute" type="radio"
                                                onclick="changeAttribute()" name="attribute[{{$index}}]"
                                                id="{{$name}}_{{$attributeValue->id}}">
                                            <label class="form-check-label" for="{{$name}}_{{$attributeValue->id}}">
                                                <span>{{ $attributeValue->value }}</span>
                                            </label>
                                        </li>
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
                                                <button class="quantity-item"><i class="fa fa-minus"></i></button>
                                            </li>
                                            <li>
                                                <input class="quantity-item" type="number" value="1">
                                            </li>
                                            <li>
                                                <button class="quantity-item"><i class="fa fa-plus"></i></button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div
                                    class="d-flex align-items-center justify-content-center justify-content-md-start gap-4">
                                    <button class="btn theme-bg-color mt-sm-4 btn-md text-white py-2 px-2 fw-300"><i
                                            data-feather="shopping-cart"></i> <span class="ms-1">Add To
                                            Cart</span></button>
                                    <a href="checkout.html"><button
                                            class="btn bg-dark text-white mt-sm-4 btn-md py-2 fw-300">Buy
                                            Now</button></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-2 col-xl-3 col-lg-5 d-none d-lg-block wow fadeInUp">
                <div class="right-sidebar-box">
                    <div class="service-section">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="service-contain">
                                    <div class="service-box">
                                        <div class="service-image">
                                            <img src="./assets/svg/product.svg" class="blur-up lazyload" alt="">
                                        </div>

                                        <div class="service-detail">
                                            <h5>Every Fresh Products</h5>
                                        </div>
                                    </div>

                                    <div class="service-box">
                                        <div class="service-image">
                                            <img src="./assets/svg/delivery.svg" class="blur-up lazyload" alt="">
                                        </div>

                                        <div class="service-detail">
                                            <h5>Free Delivery For Order Over $50</h5>
                                        </div>
                                    </div>

                                    <div class="service-box">
                                        <div class="service-image">
                                            <img src="./assets/svg/discount.svg" class="blur-up lazyload" alt="">
                                        </div>

                                        <div class="service-detail">
                                            <h5>Daily Mega Discounts</h5>
                                        </div>
                                    </div>

                                    <div class="service-box">
                                        <div class="service-image">
                                            <img src="./assets/svg/market.svg" class="blur-up lazyload" alt="">
                                        </div>

                                        <div class="service-detail">
                                            <h5>Best Price On The Market</h5>
                                        </div>
                                    </div>
                                    <div class="service-box">
                                        <div class="">
                                            <span>Sold by</span>
                                            <h3>{{ $product->seller->store->getTranslation('store_name') }}</h3>
                                        </div>

                                        <div class="service-detail">
                                            <a href="{{ route('public.seller.seller_shop', $product->seller->store->slug) }}">Visit Store</a>
                                        </div>
                                    </div>
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
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link text-start" id="info-tab" data-bs-toggle="tab"
                                        data-bs-target="#info" type="button" role="tab">warranty</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link text-start" id="qa-tab" data-bs-toggle="tab"
                                        data-bs-target="#qa" type="button" role="tab">Question & Answer</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link text-start" id="care-tab" data-bs-toggle="tab"
                                        data-bs-target="#care" type="button" role="tab">Store Details</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-10">
                        <div class="product-details px-4">
                            <div class="tab-content custom-tab" id="myTabContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel">
                                    <div class="product-description">
                                        <div class="nav-desh">
                                            <p>Jelly beans carrot cake icing biscuit oat cake gummi bears tart.
                                                Lemon drops carrot cake pudding sweet gummi bears. Chocolate cake
                                                tart cupcake donut topping liquorice sugar plum chocolate bar. Jelly
                                                beans tiramisu caramels jujubes biscuit liquorice chocolate. Pudding
                                                toffee jujubes oat cake sweet roll. Lemon drops dessert croissant
                                                danish cake cupcake. Sweet roll candy chocolate toffee jelly sweet
                                                roll halvah brownie topping. Marshmallow powder candy sesame snaps
                                                jelly beans candy canes marshmallow gingerbread pie.</p>
                                        </div>

                                        <div class="nav-desh">
                                            <div class="desh-title">
                                                <h5>Organic:</h5>
                                            </div>
                                            <p>vitae et leo duis ut diam quam nulla porttitor massa id neque aliquam
                                                vestibulum morbi blandit cursus risus at ultrices mi tempus
                                                imperdiet nulla malesuada pellentesque elit eget gravida cum sociis
                                                natoque penatibus et magnis dis parturient montes nascetur ridiculus
                                                mus mauris vitae ultricies leo integer malesuada nunc vel risus
                                                commodo viverra maecenas accumsan lacus vel facilisis volutpat est
                                                velit egestas dui id ornare arcu odio ut sem nulla pharetra diam sit
                                                amet nisl suscipit adipiscing bibendum est ultricies integer quis
                                                auctor elit sed vulputate mi sit amet mauris commodo quis imperdiet
                                                massa tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada
                                                proin libero nunc consequat interdum varius sit amet mattis
                                                vulputate enim nulla aliquet porttitor lacus luctus accumsan.</p>
                                        </div>

                                        <div class="banner-contain nav-desh">
                                            <img src="./assets/images/offer-banner/img2.webp"
                                                class="bg-img blur-up lazyload h-100" alt="">
                                        </div>

                                        <div class="nav-desh">
                                            <div class="desh-title">
                                                <h5>From The Manufacturer:</h5>
                                            </div>
                                            <p>Jelly beans shortbread chupa chups carrot cake jelly-o halvah apple
                                                pie pudding gingerbread. Apple pie halvah cake tiramisu shortbread
                                                cotton candy croissant chocolate cake. Tart cupcake caramels gummi
                                                bears macaroon gingerbread fruitcake marzipan wafer. Marzipan
                                                dessert cupcake ice cream tootsie roll. Brownie chocolate cake
                                                pudding cake powder candy ice cream ice cream cake. Jujubes soufflé
                                                chupa chups cake candy halvah donut. Tart tart icing lemon drops
                                                fruitcake apple pie.</p>

                                            <p>Dessert liquorice tart soufflé chocolate bar apple pie pastry danish
                                                soufflé. Gummi bears halvah gingerbread jelly icing. Chocolate cake
                                                chocolate bar pudding chupa chups bear claw pie dragée donut halvah.
                                                Gummi bears cookie ice cream jelly-o jujubes sweet croissant.
                                                Marzipan cotton candy gummi bears lemon drops lollipop lollipop
                                                chocolate. Ice cream cookie dragée cake sweet roll sweet roll.Lemon
                                                drops cookie muffin carrot cake chocolate marzipan gingerbread
                                                topping chocolate bar. Soufflé tiramisu pastry sweet dessert.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="review" role="tabpanel">
                                    <div class="review-box">
                                        <div class="row">
                                            <div class="col-xl-5">
                                                <div class="product-rating-box">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="product-main-rating">
                                                                <h2>3.40
                                                                    <i data-feather="star"></i>
                                                                </h2>

                                                                <h5>5 Overall Rating</h5>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-12">
                                                            <ul class="product-rating-list">
                                                                <li>
                                                                    <div class="rating-product">
                                                                        <h5>5<i data-feather="star"></i></h5>
                                                                        <div class="progress">
                                                                            <div class="progress-bar"
                                                                                style="width: 40%;">
                                                                            </div>
                                                                        </div>
                                                                        <h5 class="total">2</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="rating-product">
                                                                        <h5>4<i data-feather="star"></i></h5>
                                                                        <div class="progress">
                                                                            <div class="progress-bar"
                                                                                style="width: 20%;">
                                                                            </div>
                                                                        </div>
                                                                        <h5 class="total">1</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="rating-product">
                                                                        <h5>3<i data-feather="star"></i></h5>
                                                                        <div class="progress">
                                                                            <div class="progress-bar"
                                                                                style="width: 0%;">
                                                                            </div>
                                                                        </div>
                                                                        <h5 class="total">0</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="rating-product">
                                                                        <h5>2<i data-feather="star"></i></h5>
                                                                        <div class="progress">
                                                                            <div class="progress-bar"
                                                                                style="width: 20%;">
                                                                            </div>
                                                                        </div>
                                                                        <h5 class="total">1</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="rating-product">
                                                                        <h5>1<i data-feather="star"></i></h5>
                                                                        <div class="progress">
                                                                            <div class="progress-bar"
                                                                                style="width: 20%;">
                                                                            </div>
                                                                        </div>
                                                                        <h5 class="total">1</h5>
                                                                    </div>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xl-7">
                                                <div class="review-people">
                                                    <ul class="review-list">
                                                        <li>
                                                            <div class="people-box">
                                                                <div>
                                                                    <div class="people-image people-text">
                                                                        <img alt="user" class="img-fluid "
                                                                            src="./assets/images/review/1.jpg">
                                                                    </div>
                                                                </div>
                                                                <div class="people-comment">
                                                                    <div class="people-name"><a
                                                                            href="javascript:void(0)" class="name">Jack
                                                                            Doe</a>
                                                                        <div class="date-time">
                                                                            <h6 class="text-content"> 29 Sep 2023
                                                                                06:40:PM
                                                                            </h6>
                                                                            <div class="product-rating">
                                                                                <ul class="rating">
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"></i>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="reply">
                                                                        <p>Avoid this product. The quality is
                                                                            terrible, and
                                                                            it started falling apart almost
                                                                            immediately. I
                                                                            wish I had read more reviews before
                                                                            buying.
                                                                            Lesson learned.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="people-box">
                                                                <div>
                                                                    <div class="people-image people-text">
                                                                        <img alt="user" class="img-fluid "
                                                                            src="./assets/images/review/2.jpg">
                                                                    </div>
                                                                </div>
                                                                <div class="people-comment">
                                                                    <div class="people-name"><a
                                                                            href="javascript:void(0)"
                                                                            class="name">Jessica
                                                                            Miller</a>
                                                                        <div class="date-time">
                                                                            <h6 class="text-content"> 29 Sep 2023
                                                                                06:34:PM
                                                                            </h6>
                                                                            <div class="product-rating">
                                                                                <div class="product-rating">
                                                                                    <ul class="rating">
                                                                                        <li>
                                                                                            <i data-feather="star"
                                                                                                class="fill"></i>
                                                                                        </li>
                                                                                        <li>
                                                                                            <i data-feather="star"
                                                                                                class="fill"></i>
                                                                                        </li>
                                                                                        <li>
                                                                                            <i data-feather="star"
                                                                                                class="fill"></i>
                                                                                        </li>
                                                                                        <li>
                                                                                            <i data-feather="star"
                                                                                                class="fill"></i>
                                                                                        </li>
                                                                                        <li>
                                                                                            <i data-feather="star"></i>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="reply">
                                                                        <p>Honestly, I regret buying this item. The
                                                                            quality
                                                                            is subpar, and it feels like a waste of
                                                                            money. I
                                                                            wouldn't recommend it to anyone.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="people-box">
                                                                <div>
                                                                    <div class="people-image people-text">
                                                                        <img alt="user" class="img-fluid "
                                                                            src="./assets/images/review/3.jpg">
                                                                    </div>
                                                                </div>
                                                                <div class="people-comment">
                                                                    <div class="people-name"><a
                                                                            href="javascript:void(0)" class="name">Rome
                                                                            Doe</a>
                                                                        <div class="date-time">
                                                                            <h6 class="text-content"> 29 Sep 2023
                                                                                06:18:PM
                                                                            </h6>
                                                                            <div class="product-rating">
                                                                                <ul class="rating">
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"></i>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="reply">
                                                                        <p>I am extremely satisfied with this
                                                                            purchase. The
                                                                            item arrived promptly, and the quality
                                                                            is
                                                                            exceptional. It's evident that the
                                                                            makers paid
                                                                            attention to detail. Overall, a
                                                                            fantastic buy!
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="people-box">
                                                                <div>
                                                                    <div class="people-image people-text">
                                                                        <img alt="user" class="img-fluid "
                                                                            src="./assets/images/review/4.jpg">
                                                                    </div>
                                                                </div>
                                                                <div class="people-comment">
                                                                    <div class="people-name"><a
                                                                            href="javascript:void(0)" class="name">Sarah
                                                                            Davis</a>
                                                                        <div class="date-time">
                                                                            <h6 class="text-content"> 29 Sep 2023
                                                                                05:58:PM
                                                                            </h6>
                                                                            <div class="product-rating">
                                                                                <ul class="rating">
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"></i>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="reply">
                                                                        <p>I am genuinely delighted with this item.
                                                                            It's a
                                                                            total winner! The quality is superb, and
                                                                            it has
                                                                            added so much convenience to my daily
                                                                            routine.
                                                                            Highly satisfied customer!</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="people-box">
                                                                <div>
                                                                    <div class="people-image people-text">
                                                                        <img alt="user" class="img-fluid "
                                                                            src="./assets/images/review/5.jpg">
                                                                    </div>
                                                                </div>
                                                                <div class="people-comment">
                                                                    <div class="people-name"><a
                                                                            href="javascript:void(0)" class="name">John
                                                                            Doe</a>
                                                                        <div class="date-time">
                                                                            <h6 class="text-content"> 29 Sep 2023
                                                                                05:22:PM
                                                                            </h6>
                                                                            <div class="product-rating">
                                                                                <ul class="rating">
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"
                                                                                            class="fill"></i>
                                                                                    </li>
                                                                                    <li>
                                                                                        <i data-feather="star"></i>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="reply">
                                                                        <p>Very impressed with this purchase. The
                                                                            item is of
                                                                            excellent quality, and it has exceeded
                                                                            my
                                                                            expectations.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="info" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table info-table">
                                            <tbody>
                                                <tr>
                                                    <td>Specialty</td>
                                                    <td>Vegetarian</td>
                                                </tr>
                                                <tr>
                                                    <td>Ingredient Type</td>
                                                    <td>Vegetarian</td>
                                                </tr>
                                                <tr>
                                                    <td>Brand</td>
                                                    <td>Lavian Exotique</td>
                                                </tr>
                                                <tr>
                                                    <td>Form</td>
                                                    <td>Bar Brownie</td>
                                                </tr>
                                                <tr>
                                                    <td>Package Information</td>
                                                    <td>Box</td>
                                                </tr>
                                                <tr>
                                                    <td>Manufacturer</td>
                                                    <td>Prayagh Nutri Product Pvt Ltd</td>
                                                </tr>
                                                <tr>
                                                    <td>Item part number</td>
                                                    <td>LE 014 - 20pcs Crème Bakes (Pack of 2)</td>
                                                </tr>
                                                <tr>
                                                    <td>Net Quantity</td>
                                                    <td>40.00 count</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="qa" role="tabpanel">
                                    <div class="information-box">
                                        <div class="question-list">
                                            <h4 class="mb-3">My Questions</h4>
                                            <li class="mb-4">
                                                <div class="people-box">
                                                    <div>
                                                        <div class="people-image people-text">
                                                            <img alt="user" class="img-fluid "
                                                                src="./assets/images/review/1.jpg">
                                                        </div>
                                                    </div>
                                                    <div class="people-comment">
                                                        <div class="people-name">Jack Doe <span class="ms-2" style="font-size: 10px">2 MAR 2024</span></div>
                                                        <div class="reply">
                                                            <p>Avoid this product. The quality is
                                                                terrible, and
                                                                it started falling apart almost
                                                                immediately.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ps-3">
                                                    <p class="m-0 text-secondary">No answer yet</p>
                                                </div>
                                            </li>
                                            <h4 class="mb-3">Other questions answered by Salextra (29)</h4>
                                            <li class="mb-3">
                                                <div class="people-box">
                                                    <div>
                                                        <div class="people-image people-text">
                                                            <img alt="user" class="img-fluid "
                                                                src="./assets/images/review/1.jpg">
                                                        </div>
                                                    </div>
                                                    <div class="people-comment">
                                                        <div class="people-name">Jack Doe <span class="ms-2" style="font-size: 10px">2 MAR 2024</span></div>
                                                        <div class="reply">
                                                            <p>Avoid this product. The quality is
                                                                terrible, and
                                                                it started falling apart almost
                                                                immediately.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ps-3">
                                                    <div class="people-box">
                                                        <div>
                                                            <div class="people-image people-text">
                                                                <img alt="user" class="img-fluid "
                                                                    src="./assets/images/review/1.jpg">
                                                            </div>
                                                        </div>
                                                        <div class="people-comment">
                                                            <div class="people-name">Seller <span class="ms-2" style="font-size: 10px">2 MAR 2024</span></div>
                                                            <div class="reply">
                                                                <p>Avoid this product. The quality is
                                                                    terrible, and
                                                                    it started falling apart almost
                                                                    immediately.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </div>
                                        <form class="qa-box">
                                            <label for="content" class="form-label">Your Question *</label>
                                            <textarea id="content" rows="3" class="form-control" placeholder="Your Question"></textarea>
                                            <button type="button" class="btn btn-md mt-3 fw-bold text-light theme-bg-color">Ask Question</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="care" role="tabpanel">
                                    <div class="information-box">
                                        <table class="table info-table">
                                            <tbody>
                                                <tr>
                                                    <td>Specialty</td>
                                                    <td>Vegetarian</td>
                                                </tr>
                                                <tr>
                                                    <td>Ingredient Type</td>
                                                    <td>Vegetarian</td>
                                                </tr>
                                                <tr>
                                                    <td>Brand</td>
                                                    <td>Lavian Exotique</td>
                                                </tr>
                                                <tr>
                                                    <td>Form</td>
                                                    <td>Bar Brownie</td>
                                                </tr>
                                                <tr>
                                                    <td>Package Information</td>
                                                    <td>Box</td>
                                                </tr>
                                                <tr>
                                                    <td>Manufacturer</td>
                                                    <td>Prayagh Nutri Product Pvt Ltd</td>
                                                </tr>
                                                <tr>
                                                    <td>Item part number</td>
                                                    <td>LE 014 - 20pcs Crème Bakes (Pack of 2)</td>
                                                </tr>
                                                <tr>
                                                    <td>Net Quantity</td>
                                                    <td>40.00 count</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Product Left Sidebar End -->
@endsection
@include('public.assets.zoomer')

@push('scripts')
@vite('resources/frontend_assets/js/pages/product/show.js')

@endpush
