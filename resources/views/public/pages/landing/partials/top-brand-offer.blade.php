
@if ($top_brand_offers->count() > 0)
    <section class="topBrand-section">
        <div class="container-fluid-lg">
            <div>
                <h2 class="text-center">Top Brand Offers</h2>
            </div>
            <div class="d-none d-lg-block">
                <div class="row gx-3 gy-3">
                    @foreach($top_brand_offers as $key => $offer)
                    <div class="col-12 col-lg-6">
                        <div class="topBrand-box w-100 bg-danger">
                            <a href="{{ $offer->link }}">
                                <img data-src="{{ $offer->getImage() }}" class="img-fluid lazyload h-100 w-100" alt="">
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="d-block d-lg-none">
                <div class="swiper topBrandSwiper w-100">
                    <div class="swiper-wrapper w-100">
                        @foreach($top_brand_offers as $offer)
                        <div class="swiper-slide w-100">
                            <div class="topBrand-box w-100 bg-danger">
                                <a href="{{ $offer->link }}">
                                    <img data-src="{{ $offer->getImage() }}" class="img-fluid h-100 w-100 lazyload" alt="">
                                </a>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </section>
@endif
