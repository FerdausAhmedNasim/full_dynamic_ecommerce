<?php

namespace App\Http\Controllers\Public;

use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $data = $request->all();
        $cartIdentifier = $request->cookie('cart_identifier');
        $cookie = $cartIdentifier;

        $cartQuery = Cart::where('cart_identifier', $cartIdentifier)
                    ->where('product_id', $data['product_id']);

        //$data['variant'] = null;
        if (isset($data['variants']) && count($data['variants']) > 0) {
            $data['variant'] = implode('-', $data['variants']);

            if (isset($data['color'])) {
                $data['variant'] = $data['color'] . '-' . $data['variant'];
            }

            $cartQuery->where('variant', $data['variant']);
        } elseif (isset($data['color'])) {
            $data['variant'] = $data['color'];
        }

        $cart = $cartQuery->first();

        if (isset($data['variant']) && $cart && $cart->variant == $data['variant']) {
            $cart->update([
                'variant'  => $data['variant'],
                'price'    => $data['price'],
                'quantity' => $cart->quantity + $data['quantity'],
                'ezzico_discount' => $data['ezzico_discount'],
            ]);
        } else {
            if (!$cartIdentifier) {
                $cartIdentifier = Str::uuid();
                $cookie = cookie('cart_identifier', $cartIdentifier, 60 * 24 * 30); // Set cookie to expire in 30 days
            }

            $data['cart_identifier'] = $cartIdentifier;

            Cart::create($data);
        }

        $carts = Cart::with('product.productDetails')->where('cart_identifier', $cartIdentifier)->get();

        $cartsData = $carts->map(function ($cart) {
            return [
                'id'                  => $cart->id,
                'quantity'            => $cart->quantity,
                'price'               => $cart->product->calculatePriceAfterDiscount($cart->price),
                'thumbnail_image_url' => $cart->product->getThumbnailImage(),
                'ezzico_discount'     => $cart->ezzico_discount,
            ];
        });

        if (isset($data['buy_now'])) {
            $isAuthenticated = auth()->check();

            if (! $isAuthenticated) {
                session(['product_slug' => $data['product_slug']]);
            }

            return response()->json([
                'guestCheckout'   => settings('guest_checkout') == 1 ? true : false,
                'isAuthenticated' => $isAuthenticated
            ]);
        }

        return response()->json([
            'carts'   => $cartsData,
            'message' => 'Item added to cart successfully'
        ])->withCookie($cookie);
    }


    public function cart()
    {
        $cartIdentifier = request()->cookie('cart_identifier');
        $carts = Cart::with('product.seller')->where('cart_identifier', $cartIdentifier)->get();

        return view('public.pages.cart.cart', [
            'carts' => $carts,
        ]);
    }

    public function cartItemRemove(Request $request)
    {
        $cartItemId = $request->input('cart_item_id');

        Cart::find($cartItemId)->delete();

        $cartIdentifier = request()->cookie('cart_identifier');
        $query = Cart::with('product')->where('cart_identifier', $cartIdentifier);

        $cartData = $query->get();
        $subTotal = 0;

        foreach ($cartData as $data) {
            $subTotal += $data->product->calculatePriceAfterDiscount($data->price);
        }

        return response()->json([
            'totalItem'   => $query->count(),
            'totalAmount' => $subTotal,
            'message'     => 'Cart item removed successfully'
        ]);
    }

    public function updateCart(Request $request)
    {
        $cartData = json_decode($request->input('cartData'), true);

        foreach ($cartData as $item) {
            $cart = Cart::find($item['cartId']);

            if ($cart) {
                $cart->quantity = $item['quantity'];
                $cart->save();
            }
        }

        $isAuthenticated = auth()->check();

        return response()->json([
            'guestCheckout'   => settings('guest_checkout') == 1 ? true : false,
            'isAuthenticated' => $isAuthenticated,
        ]);
    }


}
