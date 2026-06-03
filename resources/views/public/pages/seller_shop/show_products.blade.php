@extends('public.layout.master')

@section('title', settings('app_title') ? settings('app_title') : 'Seller Products')

@php
use App\Library\Enum;
@endphp

@section('content')

<!-- ======= Breadcrumbs ======= -->
{!! \App\Library\Html::breadcrumbsSection('Products',$route_name??'', $route??'', $route_type??'', $modal??'') !!}
<!-- End Breadcrumbs -->

<section class="section-b-space shop-section">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-custom-3">
                <div class="left-box wow fadeInUp">
                    @include('public.pages.seller_shop.partials.filter_sidebar')
                </div>
            </div>

            <div class="col-custom-">
                <div class="show-button">
                    <div class="filter-button-group">
                        <div class="filter-button d-inline-block d-lg-none">
                            <a><i class="fa-solid fa-filter"></i> Filter Menu</a>
                        </div>
                    </div>

                    <div class="top-filter-menu">
                        <div class="category-dropdown">
                            <h5 class="text-content">Sort By :</h5>
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown">
                                    <span>Most Popular</span> <i class="fa-solid fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" id="aToz" onclick="filter('latest_on_top')" href="javascript:void(0)">
                                        Latest Product</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="zToa" onclick="filter('oldest_on_top')" href="javascript:void(0)">
                                        Oldest Product</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="low" onclick="filter('price_low')" href="javascript:void(0)">
                                        Low - High Price</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="high" onclick="filter('price_high')" href="javascript:void(0)">
                                        High - Low Price</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="rating_high" onclick="filter('rating_high')" href="javascript:void(0)">
                                        High - Low Rating</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="rating_low" onclick="filter('rating_low')" href="javascript:void(0)">
                                        Low - High Rating</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="grid-option d-none d-md-block">
                            <ul>
                                <li class="three-grid">
                                    <a href="javascript:void(0)">
                                        <img src="{{ asset(Enum::GRID3_IMAGE) }}" class="blur-up lazyload" alt="">
                                    </a>
                                </li>
                                <li class="grid-btn d-xxl-inline-block d-none active">
                                    <a href="javascript:void(0)">
                                        <img src="{{ asset(Enum::GRID4_IMAGE) }}"
                                            class="blur-up lazyload d-lg-inline-block d-none" alt="">
                                        <img src="{{ asset(Enum::GRID_IMAGE) }}"
                                            class="blur-up lazyload img-fluid d-lg-none d-inline-block" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
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
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        function sortProducts(sortBy) {
        }
        $('.dropdown-item').click(function(e) {
            e.preventDefault();
            var sortBy = $(this).attr('id');
            sortProducts(sortBy);
        });
    });
</script>
@endpush

