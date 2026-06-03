@extends('public.layout.master')
@section('title', 'Products')

@section('content')
@php
use \App\Library\Enum;
@endphp
<!-- ======= Breadcrumbs ======= -->
{!! \App\Library\Html::breadcrumbsSection('Products',$route_name??'', $route??'', $route_type??'', $modal??'') !!}
<!-- End Breadcrumbs -->

<!-- Shop Section Start -->
<section class="section-b-space shop-section">
    <div class="container-fluid-lg">
        <div class="row">
        <div class="col-custom-3 wow fadeInUp">
            @include('public.pages.product.partials.filter_sidebar')
        </div>
            <div class="col-custom- wow fadeInUp">
                <div class="show-button">
                    <div class="filter-button-group mt-0">
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
                                    <span>Latest Product</span> <i class="fa-solid fa-angle-down"></i>
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
                                <li class="three-grid d-none d-lg-block">
                                    <a href="javascript:void(0)">
                                        <img src="{{ asset('frontend/svg/grid-3.svg') }}" class="blur-up lazyload" alt="">
                                    </a>
                                </li>
                                {{-- <li class="grid-btn d-xxl-inline-block d-none active">
                                    <a href="javascript:void(0)">
                                        <img src="{{ asset('frontend/svg/grid-4.svg') }}"
                                            class="blur-up lazyload d-lg-inline-block d-none" alt="">
                                        <img src="{{ asset('frontend/svg/grid.svg') }}"
                                            class="blur-up lazyload img-fluid d-lg-none d-inline-block" alt="">
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                    </form>
                </div>

                <div
                    class="row g-sm-4 g-3 row-cols-xxl-3 row-cols-xl-2 row-cols-lg-2 row-cols-md-2 row-cols-2 product-list-section">
                    @forelse($products??[] as $key => $product)
                        @include('public.pages.product.product')
                    @empty
                    <div style="width: 100%; height: 100vh;text-align: center;">
                        <img src="{{ Vite::asset(Enum::NO_DATA_IMAGE_PATH) }}" class="img-fluid blur-up lazyload" alt="">
                            <h2 class="mt-3"> No Data Found </h2>
                    </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Shop Section End -->
@endsection

@push('scripts')
<!-- Price Range Js -->
<script src="{{ asset('frontend/js/ion.rangeSlider.min.js') }}"></script>

<!-- sidebar open js -->
<script src="{{ asset('frontend/js/filter-sidebar.js') }}"></script>

@vite('resources/frontend_assets/js/pages/product/show.js')

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