<section class="category-section-3">
    <div class="container-fluid-lg">
        <div class="mb-md-4 d-flex">
            <ul class="nav nav-tabs tab-style-color-2 tab-style-color" id="myTab">
                <li class="nav-item">
                    <button class="nav-link btn active" id="Categories-tab" data-bs-toggle="tab"
                        data-bs-target="#Categories" type="button">Shop By Category</button>
                </li>

                <li class="nav-item">
                    <button class="nav-link btn" id="Brand-tab" data-bs-toggle="tab" data-bs-target="#Brand"
                        type="button">Shop By Brand</button>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-12 tab-pane fade show active" id="Categories" role="tabpanel">
                <div class="category-slider-1 arrow-slider wow" >
                    @foreach($categories as $key => $category)
                    <div class="wow fadeInDown" data-wow-delay="{{0.05*$key}}s">
                        <div class="category-box-list">
                            @php
                                $childCategories = childCategories($category->id);
                            @endphp
                            <a href="{{ route('public.product.category_wise', $category->slug) }}" class="category-name">
                                <h4 style="height: 40px">{{ Str::limit($category->getTranslation('title'), 25) }}</h4>
                                <h6>{{ App\Models\Product::whereIn('category_id', $childCategories)->approved()->published()->count() }} items</h6>
                            </a>
                            <div class="category-box-view">
                                <a href="{{ route('public.product.category_wise', $category->slug) }}">
                                    <img src="{{ $category->getIconImage() }}"
                                        class="img-fluid blur-up lazyload" alt="">
                                </a>
                                <button onclick="location.href = '{{ route('public.product.category_wise', $category->slug) }}'" class="btn shop-button">
                                    <span>Shop Now</span>
                                    <i class="fas fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 tab-pane fade position-relative brand-list" id="Brand" role="tabpanel">
                <div class="swiper brandSwiper">
                    <div class="swiper-wrapper">
                        @foreach($brands as $key => $brand)
                        <div class="swiper-slide">
                            <div class="wow fadeInDown" data-wow-delay="{{0.05*$key}}s">
                                <div class="category-box-list">
                                    <a href="{{ route('public.product.brand_wise', $brand->slug) }}" class="category-name">
                                        <h4 style="height: 40px">{{ Str::limit($brand->getTranslation('title'), 25) }}</h4>
                                        <h6>{{ count($brand->products->where('approved', true)) }} items</h6>
                                    </a>
                                    <div class="category-box-view">
                                        <a href="{{ route('public.product.brand_wise', $brand->slug) }}">
                                            <img src="{{ $brand->getThumbnailImage() }}"
                                                class="img-fluid mb-1 blur-up lazyload" alt="">
                                        </a>
                                        <button onclick="location.href = '{{ route('public.product.brand_wise', $brand->slug) }}'" class="btn shop-button">
                                            <span>Shop Now</span>
                                            <i class="fas fa-angle-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-button-next brand-next"></div>
                <div class="swiper-button-prev brand-prev"></div>
            </div>
        </div>
    </div>
</section>
