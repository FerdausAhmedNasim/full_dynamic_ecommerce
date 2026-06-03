@php
    use App\Models\Cart;

    $cartIdentifier = request()->cookie('cart_identifier');
    $cartItems = Cart::with('product')->where('cart_identifier', $cartIdentifier)->get();
    $totalAmount = 0;
@endphp

<div class="button-item">
    <button class="item-btn btn text-white">
        <i class="iconly-Bag-2 icli"></i>
    </button>
</div>
<div class="item-section">
    <button class="close-button">
        <i class="fas fa-times"></i>
    </button>
    <h6>
        <i class="iconly-Bag-2 icli"></i>
        <span class="item-title">{{ count($cartItems) > 0 ? count($cartItems) : 'No' }} Items</span>
    </h6>

    <ul class="items-image">
        @if(count($cartItems) > 0)
            @foreach($cartItems as $key => $item)
                @php
                    $itemTotal = Cart::getTotalAmount($item->quantity, $item->product->calculatePriceAfterDiscount($item->price)) - $item->quantity * $item->ezzico_discount;
                    $totalAmount += $itemTotal; 
                @endphp

                @if($key < 3)
                    <li>
                        <img src="{{ $item->product->getThumbnailImage() }}" alt="">
                    </li>
                @endif
            @endforeach
            
            @if(count($cartItems) - 3 > 0)
                <li>+{{ count($cartItems) - 3 }}</li>
            @endif

        {{-- @else
            <li>0</li> --}}
        @endif
    </ul>

    <a href="{{ url('/checkout') }}">
        <button class="btn item-button btn-sm fw-bold cart-total"> {{ getFormattedAmount($totalAmount) }}</button>
    </a>
</div>
