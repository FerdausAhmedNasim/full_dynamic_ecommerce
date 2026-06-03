@extends('public.layout.master')

@section('title', 'Brand List')

@section('content')
<!-- ======= Breadcrumbs ======= -->
{!! \App\Library\Html::breadcrumbsSection('Brands') !!}
<!-- End Breadcrumbs -->
<section class="brand-page-section">
    <div class="container-fluid-lg mb-4">
        <div class="row gx-md-4 gx-1 gy-4">
            @foreach ($brands as $brand)
            <div class="col-xxl-3 col-md-6 col-6">
                <div class="brand-shop shadow-lg p-3 rounded-2">
                    <div class="row">
                        <div class="col-md-5 col-12 brand-box-view">
                            <div class="brand-box-img w-100 d-flex justify-content-center align-items-center">
                                <a href="{{ route('public.product.brand_wise', $brand->slug) }}">
                                    <img src="{{ $brand->getThumbnailImage() }}" class="img-fluid lazyload" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-7 col-12 brand-details d-flex align-items-center">
                            <div>
                                <a href="{{ route('public.product.brand_wise', $brand->slug) }}">
                                    <h4>{{$brand->getTranslation("title")}}</h4>
                                </a>
                                <h6 class="my-1">{{ count($brand->products) }} items</h6>
                               <a href="{{ route('public.product.brand_wise', $brand->slug) }}">
                                    <button class="shop-button mt-1">
                                        <span>Shop Now</span>
                                        <i class="fas fa-angle-right"></i>
                                    </button>
                               </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if ($brands->hasPages())
        <nav class="custom-pagination mb-2">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $brands->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $brands->previousPageUrl() }}" tabindex="-1">
                        <i class="fa-solid fa-angles-left"></i>
                    </a>
                </li>

                @foreach ($brands->getUrlRange(1, $brands->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $brands->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
                @endforeach

                <li class="page-item {{ $brands->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $brands->nextPageUrl() }}">
                        <i class="fa-solid fa-angles-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
        @endif
    </div>
</section>
@endsection
