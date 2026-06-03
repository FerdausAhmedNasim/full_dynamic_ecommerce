<?php

namespace App\Library\Services\Public;

use Vite;
use Exception;
use App\Library\Enum;
use App\Library\Html;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductStock;
use App\Models\ProductReview;
use Illuminate\Support\Facades\DB;
use App\Library\Services\Admin\BaseService;
use App\Models\Brand;

class ProductService extends BaseService
{
    public function findStock($variant_ids, $product_id)
    {
        return ProductStock::with('product', 'attachment')->where('variant_ids', $variant_ids)->where('product_id', $product_id)->first();
    }

    public function getFilterProduct(array $datas, $filterBy)
    {
        $category_ids = $brand_ids = $rating = [];
        $seller_id = '';

        foreach($datas as $key => $data) {
            if($data['name'] == 'category[]') {
                array_push($category_ids, (int)$data['value']);
            } elseif($data['name'] == 'brand[]') {
                array_push($brand_ids, (int)$data['value']);
            } elseif($data['name'] == 'rating[]') {
                array_push($rating, (float)$data['value']);
            } elseif($data['name'] == 'seller_id') {
                $seller_id = (int)$data['value'];
            } else {
                if($data['value']) {
                    $price_range = explode(";", $data['value']);
                    array_walk($price_range, function (&$v) { $v = floatval($v); });
                } else {
                    $price_range = null;
                }
            }
        }

        $query = Product::with('category', 'productStocks')->approved()->published();

        if (!empty($category_ids)) {
            $allIds = [];

            foreach ($category_ids as $category_id) {
                $ids = childCategories($category_id);
                $allIds = array_merge($allIds, $ids);
            }

            $query->whereIn('category_id', array_unique($allIds));
        }

        if (isset($brand_ids) && $brand_ids != null) {
            $query->whereIn('brand_id', $brand_ids);
        }

        if (isset($price_range) && $price_range != null) {
            $query->whereBetween('unit_price', $price_range);
        }

        if (isset($rating) && $rating != null) {
            $query->whereBetween('rating', [$rating[sizeof($rating) - 1], $rating[0]]);
        }

        if (isset($filterBy) && $filterBy != null) {

            switch ($filterBy) {
                case 'latest_on_top':
                    $query->orderByDesc('id');

                    break;
                case 'oldest_on_top':
                    $query->orderBy('id');

                    break;
                case 'price_high':
                    $query->orderByDesc('unit_price');

                    break;
                case 'price_low':
                    $query->orderBy('unit_price');

                    break;
                case 'rating_high':
                    $query->orderByDesc('rating');

                    break;
                case 'rating_low':
                    $query->orderBy('rating');

                    break;
                default:
                    $query->orderBy('id', 'desc');

                    break;
            }
        }

        if (isset($seller_id) && $seller_id != null) {
            $query->where('seller_id', $seller_id);
        }

        $products = $query->get();
        $elements = '';

        if(count($products) > 0) {
            foreach($products as $key => $product) {

                if ($product->has_variant && count($product->productStocks) > 1) {
                    $addCart = '<div class="w-50"><a class="d-block w-100" href="' . route('public.product.show', $product->slug) . '">
                    <button class="buy-button position-static buy-button-2 btn d-block w-100">
                        Add To Cart
                    </button>
                </a></div>';
                }else {
                    $disabledAttribute = $product->current_stock > 0 ? "" : "disabled";
                    $addCart = '<div class="w-50"><button class="buy-button position-static buy-button-2 btn btn-cart w-100" ' . $disabledAttribute . '>
                    Add To Cart
                </button></div>';
                }

                if ($product->has_variant && count($product->productStocks) > 1) {
                    $buyNow = '<div class="w-50"><a class="d-block w-100" href="' . route('public.product.show', $product->slug) . '">
                    <button class="buy-button position-static buy-button-2 btn w-100">
                        Buy Now
                    </button>
                </a></div>';
                }else {
                    $disabledAttribute = $product->current_stock > 0 ? "" : "disabled";
                    $buyNow = '<div class="w-50"><button class="buy-button position-static buy-button-2 btn w-100 buyNow" ' . $disabledAttribute . '>
                    Buy Now
                </button></div>';
                }

                $elements .= '<div class="wow fadeInUp" data-wow-delay="' . (0.05 * $key) . 's">
                <div class="product-box-4 custom-product">
                    <div class="product-image">
                        <div class="label-flex">
                            <button class="btn p-0 wishlist btn-wishlist notifi-wishlist">
                                <i class="iconly-Heart icli"></i>
                            </button>
                        </div>

                        <div class="product-card-rating">
                                <span>'. $product->getOverallRetting(true) .'</span>
                                <i class="fa fa-star text-yellow mx-1"></i>
                                <span>5</span>
                        </div>

                        <a href="' . route('public.product.show', $product->slug) . '">
                            <img src="' . $product->getThumbnailImage() . '" class="img-fluid" alt="">
                        </a>
                    </div>

                    <div class="product-detail"><a href="' . route('public.product.show', $product->slug) . '">
                            <h5 class="d-none d-md-block">' . $product->getTranslation('short_title') . '</h5>
                            <h5 class="d-md-none">' . $product->getTranslation('mobile_short_title') . '</h5>
                        </a>
                        <h5 class="price theme-color">' . getFormattedAmount($product->getPriceAfterDiscount()) . '<del
                                class="text-content fs-6">' . getFormattedAmount($product->unit_price) . '
                            </del> </h5>
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

                            <div class="d-flex align-content-center" style="gap: 4px;">
                                '. $buyNow .'
                                '. $addCart .'
                            </div>
                        </div>
                    </div>
                    <form action="#">
                        <input type="hidden" name="product_id" class="product_id" value="'. $product->id .'">
                        <input type="hidden" name="user_id" class="user_id" value="'. authUser()?->id .'">
                        <input type="hidden" name="current_stock" class="current_stock" value="'. $product->current_stock .'">
                        <input type="hidden" name="product_price" class="product_price" value="'. $product->unit_price .'">
                        <input type="hidden" name="product_slug" class="product_slug" value="'. $product->slug .'">
                    </form>
                </div>
            </div>';
            }
        } else {
            $elements = '<div style="width: 100%;
            height: 100vh;text-align: center;">
            <img src="' . Vite::asset(Enum::NO_DATA_IMAGE_PATH) . '" class="img-fluid blur-up lazyload" alt="">
                <h2 class="mt-3"> No Data Found</h2>
            </div>';
        }

        return $elements;
    }

    public function reviewStore(array $data, Product $product)
    {
        DB::beginTransaction();

        try {
            $data['product_id'] = $product->id;
            $data['customer_id'] = authId();
            $product_review = ProductReview::create($data);

            $product->update([
                'rating' => $product->getOverallRetting(),
            ]);

            // Review Image
            if (isset($data['images']) && $data['images'] != '') {

                foreach ($data['images'] as $image) {
                    attachmentStore($image, $product_review, Enum::PRODUCT_REVIEW_IMAGE_DIR, Enum::ATTACHMENT_TYPE_GALLERY);
                }
            }

            DB::commit();

            return $this->handleSuccess('Review Given Successfully !!');
        } catch (Exception $e) {

            return $this->handleException($e);
        }
    }

    public function searchProduct(string $searchBy)
    {
        try {
            $keywords = explode(' ', $searchBy);

            $category_ids = Category::with('languages')
                                    ->whereHas('languages', function ($q) use ($keywords) {
                                        foreach ($keywords as $word) {
                                            $q->where('title', 'like', '%' . $word . '%');
                                        }
                                    })
                                    ->pluck('id');
            
            $brand_ids = Brand::with('languages')
                         ->whereHas('languages', function ($q) use ($keywords) {
                            foreach ($keywords as $word) {
                                $q->where('title', 'like', '%' . $word . '%');
                            }
                         })->pluck('id');

            $query = Product::with('category', 'productLanguages');

            if($category_ids && count($category_ids)) {
                $query->whereIn('category_id', $category_ids);
            }

            if($brand_ids && count($brand_ids)) {
                $query->orWhereIn('brand_id', $brand_ids);
            }

            $query->orWhereHas(
                'productLanguages',
                function ($q) use ($keywords) {
                    foreach ($keywords as $word) {
                        $q->where('title', 'like', '%' . $word . '%');
                    }
                }
            );

            return $query->approved()->published()->get();

        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function searchSellerProduct(string $searchBy, $seller_id = null)
    {
        try {
            $category_ids = Category::with('languages')
                            ->whereHas('languages', function ($q) use ($searchBy) {
                                $q->where('title', 'like', '%' . $searchBy . '%');
                            })->pluck('id');

            $brand_ids = Brand::with('languages')
                         ->whereHas('languages', function ($q) use ($searchBy) {
                             $q->where('title', 'like', '%' . $searchBy . '%');
                         })->pluck('id');

            $query = Product::with('category', 'productLanguages', 'productStocks')->approved()->published();

            if($category_ids && count($category_ids)) {
                $query->whereIn('category_id', $category_ids);
            }

            if($brand_ids && count($brand_ids)) {
                $query->orWhereIn('brand_id', $brand_ids);
            }

            $query->orWhereHas(
                'productLanguages',
                function ($q) use ($searchBy) {
                    $q->where('title', 'like', '%' . $searchBy . '%');
                }
            );

            return $query->where("seller_id", $seller_id)->approved()->published();

        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }
}
