<?php

namespace App\Http\Controllers\Public;

use App\Models\Cart;
use App\Models\Page;
use App\Library\Enum;
use App\Library\Html;
use App\Models\Brand;
use App\Models\Video;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use App\Models\Advertise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    private $load_more_limit = 20;

    public function index()
    {
        $cartIdentifier = request()->cookie('cart_identifier');

        $sliders = Slider::active()->orderBy('order', 'asc')->get()->chunk(2);
        $m_sliders = Slider::active()->orderBy('order', 'asc')->get();
        
        $products = Product::with('productStocks')
            ->approved()
            ->published()
            ->featured()
            ->latest()
            ->paginate(20);

        return view('public.pages.landing.index', [
            'products'           => $products,
            'flashSale_products' => Product::with('productStocks')->whereIn('id', Advertise::getFlashSaleProductIds())->get(),
            'topSale_products'   => Product::with('productStocks')->whereIn('id', Advertise::getTopSaleProductIds())->get(),
            'deals'              => Advertise::getDealYouCanNotMiss(),
            'top_brand_offers'   => Advertise::getTopBrandOffers(),
            'categories'         => Category::with('products')->onlyParent()->active()->featured()->get(),
            'brands'             => Brand::with('products')->active()->featured()->get(),
            'sliders'            => $sliders,
            'video'              => Video::where('status', true)->first(),
            'm_sliders'          => $m_sliders,
            'cartItems'          => Cart::with('product')->where('cart_identifier', $cartIdentifier)->get(),
            'has_cookie'         => request()->cookie('cookie_content') != null ? true : false,
        ]);
    }

    public function loadMoreData(Request $request)
    {
        $start = $request->input('start');

        $products = Product::with('productStocks')
            ->approved()
            ->published()
            ->featured()
            ->latest()
            ->offset($start)
            ->limit($this->load_more_limit)
            ->get();

        $html = '';

        if (count($products) > 0) {
            foreach($products as $key => $product) {
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

                            <div class="product-card-rating">
                                    <span>'. $product->getOverallRetting(true) .'</span>
                                    <i class="fa fa-star text-yellow mx-1"></i>
                                    <span>5</span>
                            </div>

                            <a href="' . route('public.product.show', $product->slug) . '">
                                <img data-src="' . $product->getThumbnailImage() . '" class="img-fluid lazyload" alt="">
                            </a>
                        </div>

                        <div class="product-detail"><a href="' . route('public.product.show', $product->slug) . '">
                                <h5 class="d-none d-md-block" title=" ' . $product->getTranslation('title') . ' ">' . $product->getTranslation('short_title') . '</h5>
                                <h5 class="d-md-none" title=" ' . $product->getTranslation('title') . ' ">' . $product->getTranslation('mobile_short_title') . '</h5>
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
                                </div>
                                <div class="d-flex align-content-center" style="gap: 4px;">';

                if ($product->has_variant && count($product->productStocks) > 1) {
                    $html .= '<div class="w-50"><a class="d-block w-100" href="' . route('public.product.show', $product->slug) . '">
                                        <button class="buy-button position-static buy-button-2 btn w-100">
                                            Buy Now
                                        </button>
                                    </a></div>';
                } else {
                    $disabledAttribute = $product->current_stock > 0 ? "" : "disabled";
                    $html .= '<div class="w-50"><button class="buy-button position-static buy-button-2 btn w-100 buyNow" ' . $disabledAttribute . '>
                                        Buy Now
                                    </button></div>';
                }
                if ($product->has_variant && count($product->productStocks) > 1) {
                    $html .= '<div class="w-50"><a class="d-block w-100" href="' . route('public.product.show', $product->slug) . '">
                                        <button class="buy-button position-static buy-button-2 btn d-block w-100">
                                            Add To Cart
                                        </button>
                                    </a></div>';
                } else {
                    $disabledAttribute = $product->current_stock > 0 ? "" : "disabled";
                    $html .= '<div class="w-50"><button class="buy-button position-static buy-button-2 btn btn-cart w-100" ' . $disabledAttribute . '>
                                        Add To Cart
                                    </button></div>';
                }

                $html .= '
                               </div>
                            </div>
                        </div>

                        <form action="#">
                            <input type="hidden" name="product_id" class="product_id" value="' . $product->id . '">
                            <input type="hidden" name="user_id" class="user_id" value="' . authUser()?->id . '">
                            <input type="hidden" name="current_stock" class="current_stock" value="' . $product->current_stock . '">
                            <input type="hidden" name="product_price" class="product_price" value="' . $product->unit_price . '">
                            <input type="hidden" name="ezzico_discount" class="ezzico_discount" value="' . $ezzicoDiscount . '">
                            <input type="hidden" name="product_slug" class="product_slug" value="'. $product->slug .'">
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

    public function PageShow($slug)
    {
        $page = Page::where('link', $slug)->first();

        return view('public.pages.page', compact('page'));
    }

}
