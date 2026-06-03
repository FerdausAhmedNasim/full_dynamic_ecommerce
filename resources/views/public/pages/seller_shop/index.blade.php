@extends('public.layout.master')

@section('title', settings('app_title') ? settings('app_title') : 'Seller Store')

@section('content')

<!-- ======= Breadcrumbs ======= -->
{!! \App\Library\Html::breadcrumbsSection('Shop Details', 'Shops', route('public.seller.index')) !!}
<!-- End Breadcrumbs -->

<!-- Seller Store Start -->
<section class="seller-store pt-2">
    <div class="container-fluid-lg">
        <div class="row g-5">
            <div class="col-12 col-lg-3">
                <div class="vendor-detail-box position-sticky top-0">
                    <div class="vendor-name">
                        <div class="vendor-logo">
                            <img src="{{ $seller?->store?->getThumbnailImage() }}" class="img-fluid rounded-2" alt="">
                            <div>
                                <h3>{{$seller->store->getTranslation('store_name')}}</h3>
                                <div class="product-rating vendor-rating">
                                    <ul class="rating">
                                        @for($i = 1; $i <= 5; $i++) @if($i <=$seller->store->rating_count)
                                            <li><i data-feather="star" class="fill"></i></li>
                                            @else
                                            <li><i data-feather="star"></i></li>
                                            @endif
                                            @endfor
                                    </ul>
                                    <span>{{number_format($seller->store->rating_count, 1)}} of 5</span>
                                </div>
                                <label class="product-label mt-2">{{$products->count()}} Products</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9">
                <div class="seller-home">
                    <div class="row seller-nav" style="background: transparent; padding: 0; border-radius: 0;">
                        <ul
                            class="col-md-6 mb-2 mb-md-0 d-flex align-items-center justify-content-md-start justify-content-center gap-4">
                            <li><a href="{{ route('public.seller.seller_shop', $seller->store->slug) }}">Home</a></li>
                            <li><a href="{{ route('public.seller.seller_products', $seller->store->slug) }}">All Products</a>
                            </li>
                        </ul>
                        <div class="col-md-6 search-input">
                            <form method="post" action="{{ route('public.seller.search.products',$seller->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="search" name="search_by" required class="form-control" placeholder="Search Products">

                                {{-- <button class="btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button> --}}

                            </form>
                        </div>
                    </div>
                    <div class="seller-banner mt-2">
                        <img src="{{ $seller->store->getBannerImage() }}" class="h-100 w-100" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Seller Store End -->

<!-- Flash Sale Section Start -->
<section class="flashSale-section">
    <div class="container-fluid-lg py-4">
        <div>
            <h2 class="text-md-center text-start">{{count($flashSale_products) ? "Flash Sale" : ''}}</h2>
        </div>
        <div class="slider-7_1 arrow-slider img-slider">
            @foreach ($flashSale_products as $key => $product)
            @include('public.pages.product.product')
            @endforeach
        </div>
    </div>
</section>
<!-- Flash Sale Section End -->

<!-- Seller Products Start -->
<section class="products-section pb-5">
    <div class="container-fluid-lg">
        <div>
            <h2 class="text-center">{{count($products) ? "Seller Products" : ''}}</h2>
        </div>

        <div class="row g-sm-4 g-3 row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2">
            @foreach ($products as $key => $product)
            @include('public.pages.product.product')
            @endforeach
        </div>

        @if ($products->hasPages())
        <nav class="custom-pagination mb-2">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $products->previousPageUrl() }}" tabindex="-1">
                        <i class="fa-solid fa-angles-left"></i>
                    </a>
                </li>

                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
                @endforeach

                <li class="page-item {{ $products->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $products->nextPageUrl() }}">
                        <i class="fa-solid fa-angles-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
        @endif
    </div>
</section>
<!-- Seller Products End -->
@endsection
