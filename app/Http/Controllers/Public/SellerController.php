<?php

namespace App\Http\Controllers\Public;

use App\Models\User;
use App\Library\Enum;
use App\Models\Store;
use App\Library\Helper;
use App\Models\Product;
use App\Models\Advertise;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Public\ProductService;
use App\Http\Requests\Public\Seller\CreateRequest;
use App\Library\Services\Admin\User\SellerService;

class SellerController extends Controller
{
    use ApiResponse;
    private $seller_service;
    private $product_service;

    public function __construct(SellerService $seller_service, ProductService $product_service)
    {
        $this->seller_service = $seller_service;
        $this->product_service = $product_service;
    }

    public function index()
    {
        $sellers = User::with('store', 'products')
                    ->whereHas('store', function($store) {
                        $store->where('active', true);
                    })
                    ->whereHas('products', function($product) {
                        $product->approved()->published();
                    })
                    ->where('user_type', Enum::USER_TYPE_SELLER)
                    ->where('status', Enum::USER_STATUS_ACTIVE)
                    ->paginate(9);

        return view('public.pages.shop.index', [
            "sellers" => $sellers
        ]);
    }

    public function sellerStore($slug)
    {
        $store = Store::where('slug', $slug)->first();
        $products = Product::approved()
                            ->published()
                            ->showHomePage()
                            ->where("seller_id", $store->seller_id)
                            ->paginate(12);

        $flash_sale = Product::with('productStocks')
                        ->find(Advertise::getFlashSaleProductIds())
                        ->where("seller_id", $store->seller_id);

        return view('public.pages.seller_shop.index', [
            "seller"             => User::find($store->seller_id),
            "products"           => $products,
            'flashSale_products' => $flash_sale,
        ]);
    }

    public function showProducts($slug)
    {
        $store = Store::where('slug', $slug)->first();
        $seller = User::where('id', $store->seller_id)->first();
        $products = Product::with('productStocks')->where("seller_id", $store->seller_id)->where('status', Enum::PRODUCT_STATUS_PUBLISHED)->paginate(16);

        // dd($store, $seller);

        return view('public.pages.seller_shop.show_products', [
            "seller"     => $seller,
            "products"   => $products,
            'route_name' => 'Shops',
            'route'      => route('public.seller.index'),
            'modal'      => $seller,
            'route_type' => 'shop',
        ]);
    }

    public function showCreateForm()
    {
        return view('public.pages.seller.become_seller', [
            'countries' => Helper::getCountries(),
            'genders'   => getDropdown(Enum::CONFIG_DROPDOWN_GENDER),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->seller_service->becomeSellerRequest($request->validated());

        if ($result) {
            return redirect()->route('public.home')->with('success', $this->seller_service->message);
        }

        return back()->withInput(request()->all())->with('error', $this->seller_service->message);
    }

    public function searchProducts(Request $request, User $seller)
    {
        return view('public.pages.seller_shop.show_products', [
            "seller"     => $seller,
            "products"   => $this->product_service->searchSellerProduct($request->search_by, $seller->id)->paginate(16),
            'route_name' => 'Shops',
            'route'      => route('public.seller.index'),
            'modal'      => $seller,
            'route_type' => 'shop',
        ]);
    }
}
