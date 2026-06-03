<?php

namespace App\Http\Controllers\Public;

use App\Library\Html;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\ProductQuestion;
use App\Http\Controllers\Controller;
use App\Library\Services\Public\ProductService;

class ProductController extends Controller
{
    private $product_service;

    public function __construct(ProductService $product_service)
    {
        $this->product_service = $product_service;
    }

    public function show(string $slug)
    {
        $product = Product::with('category', 'brand', 'colors', 'productDetails', 'attachments', 'productStocks', 'productServices.productServiceLanguages')
                            ->where('slug', $slug)->first();

        return view('public.pages.product.details', [
            'product'                => $product,
            'first_stock'            => $product->productStocks[0],
            'reviews'                => $product->productReview(true)->get(),
            'attributes'             => isset($product->attribute_sets) ? Attribute::with('attributeValues')->whereIn('id', json_decode($product->attribute_sets))->get() : [],
            'overallRetting'         => $product->getOverallRetting(true),
            'ratingWiseTotalRetting' => $product->getRatingWiseTotalRating(true),
            'customer_questions'     => ProductQuestion::with('childrenQuestion.seller', 'customer')
                                        ->active()
                                        ->whereNull('parent_id')
                                        ->where('product_id', $product->id)
                                        ->latest()
                                        ->take(4)
                                        ->get(),
            'button_component' => \Share::page(url('/products/share/' . $product->slug), 'test')
                                        ->facebook()
                                        ->twitter()
                                        ->linkedin()
                                        ->whatsapp(),
            'recent_products'  => Product::with('category', 'brand', 'colors', 'productDetails', 'attachments', 'productStocks')->approved()->published()->orderBy('id', 'desc')->get(),
            'related_products' => Product::with('category', 'brand', 'colors', 'productDetails', 'attachments', 'productStocks')->where('category_id', $product->category_id)->approved()->published()->get(),
            'top_products'     => Product::with('category', 'brand', 'colors', 'productDetails', 'attachments', 'productStocks')->orderBy('rating', 'desc')->approved()->published()->get(),
        ]);
    }

    public function loadMoreQuestion(string $slug, Request $request)
    {
        $offset = $request->input('offset', 0);
        $product = Product::with('category', 'brand', 'colors', 'productDetails', 'attachments', 'productStocks')
                            ->where('slug', $slug)->first();

        $question_answers = ProductQuestion::with(["seller", "childrenQuestion.customer", "childrenQuestion.seller", 'customer'])
                            ->active()
                            ->latest()
                            ->whereNull('parent_id')
                            ->where('product_id', $product->id)
                            ->offset($offset)
                            ->limit(4)
                            ->get();

        return response()->json($question_answers);
    }

    public function variant(Request $request)
    {
        $stock = $this->product_service->findStock(getVariant($request['attributes']), $request['product_id']);
        $ezzicoDiscount = 0;

        if (! $stock->product->has_discount) {
            $product = Product::find($request['product_id']);
            $ezzicoDiscount = $product->getEzzicoDiscount($stock->unit_price);
        }

        $data = [
            'price'                => getFormattedAmount($stock->unit_price),
            'discounted_price'     => $stock->product->has_discount || $ezzicoDiscount ? $stock->getPriceAfterDiscount(true) : '',
            'discounted_info'      => $stock->product->has_discount || $ezzicoDiscount ? $stock->getDiscountInfo() : '',
            'sku'                  => $stock->sku,
            'variant_ids'          => $stock->variant_ids,
            'current_stock'        => $stock->current_stock,
            'image'                => $stock->getVariantImage(),
            'stock_badge'          => Html::StockBadge($stock->current_stock, $stock->product->stock_visibility),
            'has_discount'         => $stock->product->has_discount,
            'has_ezzico_discount'  => $ezzicoDiscount > 0 ? 1 : 0,
        ];

        return $data;
    }

    // Question Store
    public function questionStore(Request $request)
    {
        if (auth()->check()) {
            $data = $request->all();
            $question = ProductQuestion::create($data);

            return response()->json($question->load("customer"));
        }
    }

    public function categoryWiseProduct(string $slug)
    {
        $category = Category::with('products.productDetails', 'parent')
                        ->where('slug', $slug)->first();

        $childCategories = childCategories($category->id);

        return view('public.pages.product.index', [
            'products'   => Product::whereIn('category_id', $childCategories)
                            ->approved()
                            ->published()
                            ->with('category', 'brand', 'colors', 'productDetails', 'attachments', 'productStocks')
                            ->get(),
            'category'   => $category,
            'modal'      => $category,
            'route_type' => 'category',
        ]);
    }

    public function brandWiseProduct(string $slug)
    {
        $brand = Brand::with('products.productDetails')->whereHas('products', function($product) {
            $product->approved()->published();
        })->where('slug', $slug)->first();

        return view('public.pages.product.index', [
            'products'   => $brand?->products->where('approved', true)->load('category', 'brand', 'colors', 'productDetails', 'attachments', 'productStocks'),
            'brand'      => $brand,
            'modal'      => $brand,
            'route_type' => 'brand',
        ]);
    }

    public function filterProduct(Request $request)
    {
        $filter_product = $this->product_service->getFilterProduct($request['attributes'], $request['filterBy']);

        return json_encode($filter_product);
    }

    public function review(Product $product, Request $request)
    {
        $this->validate($request, [
            'rating'  => 'required|max:5',
            'comment' => 'required',
            'images'  => 'nullable|array|max:5',
        ]);

        $result = $this->product_service->reviewStore($request->all(), $product);

        if ($result) {
            return json_encode(['status' => 'success', 'msg' => $this->product_service->message]);
        }

        return json_encode(['status' => 'error', 'msg' => $this->product_service->message]);
    }

    public function searchProduct(Request $request)
    {
        return view('public.pages.product.index', [
            'products' => $this->product_service->searchProduct($request->search_by),
        ]);
    }

    public function share(string $slug)
    {
        $product = Product::with('category', 'brand', 'colors', 'productDetails', 'attachments', 'productStocks')
                            ->where('slug', $slug)->first();

        return view('public.pages.product.share', [
            'product'                => $product,
            'first_stock'            => $product->productStocks[0],
            'reviews'                => $product->productReview(true)->get(),
            'attributes'             => isset($product->attribute_sets) ? Attribute::with('attributeValues')->whereIn('id', json_decode($product->attribute_sets))->get() : [],
            'overallRetting'         => $product->getOverallRetting(true),
            'ratingWiseTotalRetting' => $product->getRatingWiseTotalRating(true),
            'customer_questions'     => ProductQuestion::with("childrenQuestion")
                                        ->active()
                                        ->whereNull('parent_id')
                                        ->where('product_id', $product->id)
                                        ->latest()
                                        ->take(4)
                                        ->get(),
            'button_component' => \Share::page(url('/products/share/' . $product->slug), 'test')
                                        ->facebook()
                                        ->twitter()
                                        ->linkedin()
                                        ->whatsapp(),
            'recent_products'  => Product::with('category', 'brand', 'colors', 'productDetails', 'attachments', 'productStocks')->approved()->published()->orderBy('id', 'desc')->get(),
            'related_products' => Product::with('category', 'brand', 'colors', 'productDetails', 'attachments', 'productStocks')->where('category_id', $product->category_id)->approved()->published()->get(),
            'top_products'     => Product::with('category', 'brand', 'colors', 'productDetails', 'attachments', 'productStocks')->where('seller_id', $product->seller_id)->orderBy('rating', 'desc')->approved()->published()->get(),
        ]);
    }
}
