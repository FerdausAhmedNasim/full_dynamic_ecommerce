<section class="home-section pt-0">
    <div class="">
        <div class="swiper heroSwiper w-100">
            <div class="swiper-wrapper w-100">
                {{-- @foreach($sliders as $slider_images)
                <div class="swiper-slide w-100 d-none d-lg-block">
                    <div class="row gy-2 gx-2 w-100">
                    @foreach($slider_images as $image)
                        <div class="col-xl-6 col-lg-6">
                            <a class="adItem" href="{{ $image->link }}">
                                <img src="{{ $image->getBackgroundImage() }}"
                                    class="bg-img blur-up lazyload" alt="">
                            </a>
                        </div>
                    @endforeach
                    </div>
                </div>
                @endforeach --}}
                @foreach($m_sliders as $slider_image)
                    <div class="swiper-slide w-100">
                        <a class="adItem" href="{{ $slider_image->link }}">
                            <img data-src="{{ $slider_image->getBackgroundImage() }}" src="{{ $slider_image->getBackgroundImage() }}"
                                class="bg-img blur-up lazyload" alt="">
                        </a>
                    </div>
                @endforeach

            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>