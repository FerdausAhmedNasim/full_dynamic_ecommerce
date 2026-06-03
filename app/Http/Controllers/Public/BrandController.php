<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Library\Enum;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with('products')->whereHas('products', function($product) {
            $product->approved()->published();
        })
        ->where('featured', Enum::BRAND_FEATURED)
        ->paginate(16);

        return view('public.pages.brand.index', [
            "brands" => $brands
        ]);
    }
}
