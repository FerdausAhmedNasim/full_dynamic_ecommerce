@if ($products->count() > 0)
    <section class="products-section pb-3">
        <div class="container-fluid-lg">
            <div>
                <h2 class="text-center">All Products</h2>
            </div>

            <div class="row g-sm-3 g-2 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-3 row-cols-md-2 row-cols-2 product-div">
            @foreach($products as $key => $product)
                @include('public.pages.product.product')
            @endforeach
            </div>

            @if ($products->hasPages())
                <button class="btn theme-bg-color mt-4 btn-md mx-auto text-white py-2 fw-bold"
                data-page="{{ $products->currentPage() + 1 }}" id="load_more">Load More</button>
            @endif
        </div>
    </section>
@endif

@push('scripts')
    @vite('resources/frontend_assets/js/pages/cart/addToCart.js')
    @vite('resources/frontend_assets/js/my-wishlist.js')

    <script>
        $(document).ready(function() {
            var start = 20;

            $('#load_more').click(function() {
                $.ajax({
                    url: "{{ route('public.load.more') }}",
                    method: "GET",
                    data: {
                        start: start
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('#load_more').html('Loading...');
                        $('#load_more').attr('disabled', true);
                    },
                    success: function(data) {

                        if (data.data.length > 0) {

                            //append data with fade in effect
                            $('.product-div').append($(data.data).hide().fadeIn(1000));
                            $('#load_more').html('Load More');
                            $('#load_more').attr('disabled', false);
                            start = data.next;
                        } else {
                            $('#load_more').html('No More Data Available');
                            $('#load_more').attr('disabled', true);
                        }
                    }
                });
            });

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
        });
        
    </script>
@endpush
