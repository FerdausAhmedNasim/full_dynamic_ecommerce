<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Library\Html;
use App\Models\Product;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    private $load_more_limit = 18;

    public function index()
    {
        $products = Product::whereHas('activeEzzicoDiscount')
                            ->inRandomOrder()
                            ->paginate($this->load_more_limit);

        return view('public.pages.Offer.index', [
            'ezzico_sales' => $products,
        ]);
    }

    public function loadMoreData(Request $request)
    {
        $start = $request->input('start');

        $ezzico_sales = Product::with('productStocks')
                            ->whereHas('activeEzzicoDiscount')
                            ->inRandomOrder()
                            ->offset($start)
                            ->limit($this->load_more_limit)
                            ->get();

        $html = '';

        if (count($ezzico_sales) > 0) {
            foreach($ezzico_sales as $key => $product) {
                $wishlist = $product->wishlist()->where('user_id', authUser()?->id)->first();
                $addClass = $wishlist ? "text-danger" : "";
                $html .= '<div class="wow fadeInUp" data-wow-delay="' . (0.05 * $key) . 's">
                    <div class="product-box-4 custom-product">
                        <div class="product-image">
                            <div class="label-flex">
                                <button class="btn p-0 wishlist btn-wishlist ' . $addClass . '">
                                    <i class="iconly-Heart icli"></i>
                                </button>
                            </div>

                            <a href="' . route('public.product.show', $product->slug) . '">
                                <img src="' . $product->getThumbnailImage() . '" class="img-fluid" alt="">
                            </a>
                        </div>

                        <div class="product-detail">' . Html::rating($product->getOverallRetting(true)) . '<a href="' . route('public.product.show', $product->slug) . '">
                                <h5 title=" ' . $product->getTranslation('title') . ' ">' . $product->getTranslation('short_title') . '</h5>
                            </a>';

                $ezzicoDiscount = $product->getEzzicoDiscount($product->getPriceAfterDiscount());

                if ($product->has_discount) {
                    $html .= '<h5 class="price theme-color">' . getFormattedAmount($product->getPriceAfterDiscount() - $ezzicoDiscount) . '
                                    <del class="text-content fs-6"> ' . getFormattedAmount($product->unit_price) . ' </del>
                                </h5>';
                } else {
                    $html .= '<h5 class="price theme-color">' . getFormattedAmount($product->unit_price - $ezzicoDiscount) . '';

                    if ($ezzicoDiscount > 0) {
                        $html .= '<del class="text-content fs-6">' . getFormattedAmount($product->unit_price) . ' </del> ';
                    }
                    $html .= '</h5>';
                }

                $html .= '
                            <div class="price-qty">
                                <div class="counter-number">
                                    <div class="counter quantity">
                                        <div class="qty-left-minus minus" data-type="minus" data-field="">
                                            <i class="fa-solid fa-minus"></i>
                                        </div>
                                        <input class="form-control input-number qty-input product_quantity" type="number" name="quantity" value="1" min="1" max="' . $product->productStocks[0]->current_stock . '">
                                        <div class="qty-right-plus plus" data-type="plus" data-field="">
                                            <i class="fa-solid fa-plus"></i>
                                        </div>
                                    </div>
                                </div>';

                if ($product->has_variant) {
                    $html .= '<a href="' . route('public.product.show', $product->slug) . '">
                                        <button class="buy-button buy-button-2 btn">
                                            <i class="iconly-Buy icli text-white m-0"></i>
                                        </button>
                                    </a>';
                } else {
                    $disabledAttribute = $product->current_stock > 0 ? "" : "disabled";
                    $html .= '<button class="buy-button buy-button-2 btn btn-cart" ' . $disabledAttribute . '>
                                        <i class="iconly-Buy icli text-white m-0"></i>
                                    </button>';
                }

                $html .= '
                            </div>
                        </div>

                        <form action="#">
                            <input type="hidden" name="product_id" class="product_id" value="' . $product->id . '">
                            <input type="hidden" name="user_id" class="user_id" value="' . authUser()?->id . '">
                            <input type="hidden" name="current_stock" class="current_stock" value="' . $product->current_stock . '">
                            <input type="hidden" name="product_price" class="product_price" value="' . $product->unit_price . '">
                            <input type="hidden" name="ezzico_discount" class="ezzico_discount" value="' . $ezzicoDiscount . '">
                        </form>

                    </div>
                </div>';
            }
        }

        return response()->json([
            'data' => $html,
            'next' => $start + $this->load_more_limit,
        ]);
    }
}
