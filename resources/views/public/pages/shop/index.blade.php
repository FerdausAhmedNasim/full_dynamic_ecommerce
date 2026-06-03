@extends('public.layout.master')

@section('title', 'Shop List')

@section('content')
<!-- ======= Breadcrumbs ======= -->
{!! \App\Library\Html::breadcrumbsSection('Shops') !!}
<!-- End Breadcrumbs -->

<section class="seller-grid-section">
    <div class="container-fluid-lg">
        <div class="row g-4">
            @foreach ($sellers as $seller)
            <div class="col-xxl-4 col-md-6">
                <div class="seller-grid-box seller-grid-box-1">
                    <div class="grid-image">
                        <div class="image">
                            <img src="{{ $seller->store->getThumbnailImage() }}" class="img-fluid" alt="">
                        </div>

                        <div class="contain-name">
                            <div>
                                <div class="since-number">
                                    <h6>Since {{$seller->created_at->format('Y')}}</h6>
                                </div>
                                <h3>{{$seller->store->getTranslation('store_name')}}</h3>
                            </div>
                            <label class="product-label">{{$seller->products()->approved()->published()->count()}} Products</label>
                        </div>
                    </div>

                    <div class="grid-contain">
                        <div class="seller-contact-details">
                            <div class="seller-contact">
                                <div class="seller-icon">
                                    <i class="fa-solid fa-map-pin"></i>
                                </div>

                                <div class="contact-detail">
                                    <h5>Address: <span> {{$seller->address ? $seller->address : "N/A"}}</span></h5>
                                </div>
                            </div>

                            <div class="seller-contact">
                                <div class="seller-icon">
                                    <i class="fa-solid fa-phone"></i>
                                </div>

                                <div class="contact-detail">
                                    <h5>Contact Us: <span> {{$seller->phone ? $seller->phone : "N/A"}}</span></h5>
                                </div>
                            </div>
                        </div>

                        <div class="seller-category">
                            <a href="{{ route('public.seller.seller_shop', $seller->store->slug) }}">
                                <button class="btn btn-sm theme-bg-color text-white fw-bold">Visit Store <i class="fa-solid fa-arrow-right-long ms-2"></i></button>
                            </a>
                            <ul class="product-image">
                                @foreach($seller->products()->approved()->published()->take(4)->get() as $product)
                                    <li>
                                        <img src="{{ $product->getThumbnailImage() }}" class="img-fluid" alt="{{ $product->getTranslation("title") }}" style="border-radius: 50%">
                                    </li>
                                @endforeach
                                @if ($seller->products()->approved()->published()->count() - 4 > 0)
                                    <li>+{{ $seller->products()->approved()->published()->count() - 4 }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if ($sellers->hasPages())
        <nav class="custom-pagination mb-2">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $sellers->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $sellers->previousPageUrl() }}" tabindex="-1">
                        <i class="fa-solid fa-angles-left"></i>
                    </a>
                </li>

                @foreach ($sellers->getUrlRange(1, $sellers->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $sellers->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                    @endforeach

                    <li class="page-item {{ $sellers->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $sellers->nextPageUrl() }}">
                        <i class="fa-solid fa-angles-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
        @endif
    </div>
</section>
@endsection
