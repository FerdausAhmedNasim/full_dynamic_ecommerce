@if ($deals->count() > 0)
    <section class="deals-section" style="padding-top: 16px;">
        <div class="container-fluid-lg">
            <div>
                <h2 class="text-center">Deals Your Can't Miss</h2>
            </div>
            <div class="swiper deals mySwiper">
                <div class="swiper-wrapper">
                    @foreach($deals as $deal)
                        <div class="swiper-slide">
                            <div class="w-100">
                                <a href="{{ $deal->link }}"><img data-src="{{ $deal->getImage() }}"
                                        class="img-fluid h-100 w-100 lazyload" alt="deals image"></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
