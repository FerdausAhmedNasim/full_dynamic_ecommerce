<?php

namespace App\Http\Controllers\Public;

use App\Models\User;
use App\Library\Enum;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Advertise;

class SellerShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $seller = User::where('id', $id)->first();
        $products = Product::where("seller_id", $id)->where('status', Enum::PRODUCT_STATUS_PUBLISHED)
                            ->where('show_home_page', Enum::PRODUCT_SHOW_HOME_PAGE)->paginate(10);

        $flash_sale = Product::find(Advertise::getFlashSaleProductIds())->where("seller_id", $id);
        return view('public.pages.seller_shop.index',[
            "seller" => $seller,
            "products" => $products,
            'flashSale_products' =>$flash_sale,
        ]);
    }

    public function showProducts($id)
    {
        $seller = User::where('id', $id)->first();
        $products = Product::where("seller_id", $id)->where('status', Enum::PRODUCT_STATUS_PUBLISHED)->paginate(16);

        return view('public.pages.seller_shop.show_products',[
            "seller" => $seller,
            "products" => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
