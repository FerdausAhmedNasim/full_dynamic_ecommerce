<?php

namespace App\Http\Controllers\Seller;

use App\Library\Enum;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Attribute;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\SellerCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Seller\ProductService;
use App\Http\Requests\Seller\Product\StoreRequest;
use App\Http\Requests\Seller\Product\UpdateRequest;

class ProductController extends Controller
{
    private $product_service;
    public function __construct(ProductService $product_service)
    {
        $this->product_service = $product_service;
    }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $filter_request = $request->only(['status', 'category_id', 'sorting']);
            return $this->product_service->dataTable($filter_request);
        }

        $categories = SellerCategory::where('seller_id', authSellerId())
                ->with('category.languages')
                ->with('category.childrenCategories.childrenCategories.childrenCategories')
                ->get();

        return view('seller.pages.product.index', [
            'status'     => $request->status,
            'categories' => $categories
        ]);
    }

    public function showAlertProducts(Request $request)
    {
        if ($request->ajax()) {
            return $this->product_service->alertDataTable();
        }

        return view('seller.pages.product.alert');
    }

    public function create(): View
    {
        $categories = SellerCategory::where('seller_id', authSellerId())
                ->with('category.languages')
                ->with('category.childrenCategories.childrenCategories.childrenCategories')
                ->get();

        return view('seller.pages.product.create', [
            'categories' => $categories,
            'brands'     => Brand::with('languages')->active()->get(),
            'units'      => getDropdown(Enum::CONFIG_DROPDOWN_UNIT),
            'colors'     => Color::active()->get(),
            'attributes' => Attribute::with('attributeValues')->active()->get(),
        ]);
    }

    public function variants(Request $request)
    {
        if ($request->has_variant == 1) {
            $variants = [];
            $product_price = $request->price ? $request->price : 0;
            $colors = false;

            if (!empty($request->colors)) {
                array_push($variants, $request->colors);
                $colors = true;
            }

            if ($request->has('attribute_sets')) {
                foreach ($request->attribute_sets as $key => $attribute_set) {
                    $attribute_values = 'attribute_values_' . $attribute_set;
                    $values = [];

                    if ($request->has($attribute_values)) {
                        foreach ($request[$attribute_values] as $value) {
                            array_push($values, $value);
                        }
                    }

                    if ($request->has($attribute_values)) {
                        array_push($variants, $values);
                    }
                }
            }

            $variants_data = $this->getVariants($variants);

            if (!empty($variants_data[0])) {
                return view('seller.pages.product.partials.variants', [
                    'variants'      => $variants,
                    'variants_data' => $variants_data,
                    'product_price' => $product_price,
                    'colors'        => $colors,
                ]);
            }

            return view('seller.pages.product.partials.variants');
        }

        return '';
    }

    public function variantsEdit(Product $product, Request $request)
    {
        if ($request->has_variant == 1) {
            $variants = [];
            $product_price = $request->unit_price;
            $colors = false;

            if (!empty($request->colors)) {
                array_push($variants, $request->colors);
                $colors = true;
            }

            if ($request->has('attribute_sets')) {
                foreach ($request->attribute_sets as $key => $attribute_set) {
                    $attribute_values = 'attribute_values_' . $attribute_set;
                    $values = [];

                    if ($request->has($attribute_values)) {
                        foreach ($request[$attribute_values] as $value) {
                            array_push($values, $value);
                        }
                    }

                    if ($request->has($attribute_values)) {
                        array_push($variants, $values);
                    }
                }
            }

            $variants_data = $this->getVariants($variants);

            if (!empty($variants_data[0])) {
                return view('seller.pages.product.partials.variants_edit', [
                    'product'       => $product,
                    'product_price' => $product_price,
                    'variants'      => $variants,
                    'variants_data' => $variants_data,
                    'colors'        => $colors,
                ]);
            }

            return view('seller.pages.product.partials.variants_edit');
        }

        return '';
    }

    public function getVariants($variants_data = [])
    {
        $all_variants = [[]];

        foreach ($variants_data as $key => $value) {
            $values = [];

            foreach ($all_variants as $variant) {
                foreach ($value as $property_value) {
                    $values[] = array_merge($variant, [$key => $property_value]);
                }
            }
            $all_variants = $values;
        }

        return $all_variants;
    }

    public function getAttributeValues(Request $request)
    {
        $attributes_sets = $request->attribute_sets;

        if (!empty($attributes_sets)) {
            $attributes = Attribute::with('attributeValues')->whereIn('id', $attributes_sets)->get();

            return view('seller.pages.product.partials.values', [
                'attributes'      => $attributes,
                'request'         => $request,
                'attributes_sets' => $attributes_sets
            ]);
        }

        return '';
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $result = $this->product_service->store($request->validated());

        if ($result) {
            return redirect()->route('seller.product.index')->with('success', $this->product_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->product_service->message);
    }

    public function edit(Product $product): View
    {
        $categories = SellerCategory::where('seller_id', authSellerId())
                ->with('category.languages')
                ->with('category.childrenCategories.childrenCategories.childrenCategories')
                ->get();

        return view('seller.pages.product.edit', [
            'product'    => $product,
            'categories' => $categories,
            'brands'     => Brand::with('languages')->active()->get(),
            'units'      => getDropdown(Enum::CONFIG_DROPDOWN_UNIT),
            'colors'     => Color::active()->get(),
            'attributes' => Attribute::with('attributeValues')->active()->get()
        ]);
    }

    public function update(UpdateRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product, 404);
        $result = $this->product_service->update($product, $request->validated());

        if ($result) {
            return redirect()->route('seller.product.index', $product->id)->with('success', $this->product_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->product_service->message);
    }

    public function destroy(Product $product): RedirectResponse
    {
        if (count($product->sellerOrderDetails)) {
            return back()->with('error', 'Unable to delete now! This product is already used.');
        }

        $product->update(['status' => Enum::PRODUCT_STATUS_TRASH]);
        $product->delete();

        return redirect()->route('seller.product.index')->with('success', __('Successfully Deleted'));
    }

    public function changeStatus(Request $request, Product $product)
    {
        abort_if($product->status == Enum::PRODUCT_STATUS_TRASH, 404);
        $result = $this->product_service->changeStatus($product);

        if ($result) {
            return redirect()->back()->with('success', $this->product_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->product_service->message);
    }

    public function isRefundable(Request $request, Product $product)
    {
        $result = $this->product_service->isRefundable($product);

        if ($result) {
            return redirect()->back()->with('success', $this->product_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->product_service->message);
    }

    public function isShowHomePage(Request $request, Product $product)
    {
        $result = $this->product_service->isShowHomePage($product);

        if ($result) {
            return redirect()->back()->with('success', $this->product_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->product_service->message);
    }

    public function cloneProduct(Product $product): View
    {
        $categories = SellerCategory::where('seller_id', authSellerId())
                ->with('category.languages')
                ->with('category.childrenCategories.childrenCategories.childrenCategories')
                ->get();

        return view('seller.pages.product.edit', [
            'product'    => $product,
            'categories' => $categories,
            'brands'     => Brand::with('languages')->active()->get(),
            'units'      => getDropdown(Enum::CONFIG_DROPDOWN_UNIT),
            'colors'     => Color::active()->get(),
            'attributes' => Attribute::with('attributeValues')->active()->get(),
            'clone'      => true,
        ]);
    }

    public function storeCloneProduct(UpdateRequest $request, Product $product): RedirectResponse
    {
        abort_unless($product, 404);
        $result = $this->product_service->storeCloneProduct($product, $request->validated());

        if ($result) {
            return redirect()->route('seller.product.index', $product->id)->with('success', $this->product_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->product_service->message);
    }

    // Reviews
    public function showReviews(Request $request, Product $product)
    {
        if ($request->ajax()) {
            $data = ProductReview::with('product.productLanguages', 'customer')->where('product_id', $product->id)->get();

            return $this->product_service->productReviewDataTable($data);
        }

        return view('seller.pages.review.index');
    }

    public function allReviews(Request $request)
    {
        $data = Product::with('productReview.product.productLanguages')->where('seller_id', authSellerId())->get()->pluck('productReview')->flatten();

        if ($request->ajax()) {
            return $this->product_service->productReviewDataTable($data);
        }

        return view('seller.pages.review.show_allReview');
    }

    public function getMessage(ProductReview $review_message)
    {
        return $review_message;
    }

    public function reviewStatus(Request $request, ProductReview $review)
    {
        abort_unless($review, 404);
        $result = $this->product_service->reviewChangeStatus($review);

        if ($result) {
            return redirect()->back()->with('success', $this->product_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->product_service->message);
    }
}
