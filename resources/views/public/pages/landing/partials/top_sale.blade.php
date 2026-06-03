@if ($topSale_products->count() > 0)
    <section class="flashSale-section">
        <div class="container-fluid-lg">
            <div>
                <h2 class="text-md-center text-start">Top Sales</h2>
            </div>
            <div class="slider-7_1 arrow-slider img-slider">
                @foreach($topSale_products as $key => $product)
                    @include('public.pages.product.product')
                @endforeach
            </div>
        </div>
    </section>
@endif

@push('scripts')
    @vite('resources/frontend_assets/js/my-wishlist.js')
@endpush
