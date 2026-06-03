<?php

namespace App\Library\Services\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Library\Enum;
use App\Models\Brand;
use App\Models\Order;
use App\Library\Helper;
use App\Models\Product;
use App\Models\Category;
use App\Models\SellerOrder;
use App\Models\ProductReview;
use App\Models\SellerOrderDetails;
use App\Models\Settlement;

class HomeService extends BaseService
{
    public function index($request)
    {
        if (isset($request->today)) {
            $from = Carbon::now()->toDateString();
            $to = Carbon::parse()->addDays(1)->format("Y-m-d");
        } elseif (isset($request->this_month)) {
            $from = Carbon::now()->startOfMonth()->toDateString();
            $to = Carbon::now()->addDays(1)->toDateString();
        } elseif (isset($request->last_month)) {
            $from = Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
            $to = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
        } elseif ($request->from && $request->to) {
            $from = $request->from;
            $to = $request->to;
        } else {
            $from = Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
            $to = Carbon::parse()->addDays(1)->format("Y-m-d");
        }

        $filterDateActive = [
            'today'      => $request->today ?? 0,
            'this_month' => $request->this_month ?? 0,
            'last_month' => $request->last_month ?? 0,
        ];

        $total_amount = Order::getTotalOrderByDate($from, $to)->where('order_status', Enum::ORDER_STATUS_TYPE_DELIVERED)->sum('total_amount');
        $shipping_cost = Order::getTotalOrderByDate($from, $to)->where('order_status', Enum::ORDER_STATUS_TYPE_DELIVERED)->sum('shipping_cost');

        $data = [
            'filterDate'      => $filterDateActive,
            'totalOrders'     => Order::getTotalOrderByDate($from, $to)->count(),
            'totalDelivered'  => Order::getTotalOrderByDate($from, $to)->where('order_status', Enum::ORDER_STATUS_TYPE_DELIVERED)->count(),
            'totalSales'      => $total_amount - $shipping_cost,
            'totalProfit'     => $this->getTotalProfit($from, $to),
            'totalProducts'   => Product::getTotalProductByDate($from, $to)->count(),
            'totalCustomer'   => User::getTotalActiveUserByType($from, $to, Enum::USER_TYPE_CUSTOMER),
            // 'totalSellers'    => User::getTotalActiveUserByType($from, $to, Enum::USER_TYPE_SELLER),
            'totalBrands'     => Brand::getTotalActiveBrand($from, $to),
            'totalCategories' => Category::getTotalActiveCategory($from, $to),
            'ratings'         => $this->getRating($from, $to),
            'totalRating'     => array_sum($this->getRating($from, $to)),
            'averageRating'   => ProductReview::active()->whereBetween('created_at', [$from, $to])->avg('rating'),
            'topCategories'   => $this->topCategories($from, $to),
            'topBrands'       => $this->topBrands($from, $to),
            'topSeller'       => $this->topSeller($from, $to),
            'topProduct'      => $this->topProduct($from, $to),
            'orderStatistics' => $this->getOrderStatistics($from, $to),
            'orders'          => Order::with('customer', 'operator')->whereBetween('created_at', [$from, $to])->latest()->take(10)->get(),
            'date_range'      => $request->from && $request->to ? Helper::dateRange($request->from, $request->to) : null,
        ];

        return $data;
    }

    // Get Total Profit Based on Seller Category Commission
    public function getTotalProfit($from, $to)
    {
        return Settlement::whereBetween('created_at', [$from, $to])->sum('commission', 'ad_cost');
    }

    // Get Status Wise Total Order for Order Statistics Chart
    private function getOrderStatistics($from, $to)
    {
        $statusCounts = Order::selectRaw('order_status, COUNT(*) as count')
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('order_status')
            ->get()
            ->keyBy('order_status')
            ->all();

        $data = [
            'Processing'   => $statusCounts[Enum::ORDER_STATUS_TYPE_PROCESSING]->count ?? 0,
            'Delivered'    => $statusCounts[Enum::ORDER_STATUS_TYPE_DELIVERED]->count ?? 0,
            'Canceled'     => $statusCounts[Enum::ORDER_STATUS_TYPE_CANCELED]->count ?? 0,
            'Returned'     => $statusCounts[Enum::ORDER_STATUS_TYPE_RETURNED]->count ?? 0,
            'Returned'     => $statusCounts[Enum::ORDER_STATUS_TYPE_PARTIAL_RETURNED]->count ?? 0,
            'Not Received' => $statusCounts[Enum::ORDER_STATUS_TYPE_NOT_RECEIVED]->count ?? 0,
            'Pending'      => $statusCounts[Enum::ORDER_STATUS_TYPE_PENDING]->count ?? 0,
            'Shipped'      => $statusCounts[Enum::ORDER_STATUS_TYPE_SHIPPED]->count ?? 0,
        ];

        return $data;
    }

    // Get Customer Rating
    private function getRating($from, $to)
    {
        $ratingCounts = ProductReview::whereBetween('created_at', [$from, $to])
            ->selectRaw('rating, COUNT(*) as count')
            ->active()
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        // Initialize data array
        $data = [];

        // Assign counts to data array with default value of 0 if no count found
        for ($i = 1; $i <= 5; $i++) {
            $data['rate_' . $i] = $ratingCounts[$i] ?? 0;
        }

        return $data;
    }

    // Get Top 5 Parent Categories with their children
    public function topCategories($from, $to)
    {
        // Get the top parent categories with their total product quantities
        $topParentCategories = Category::with(['childrenCategories.products.sellerOrderDetails'])
            ->select('categories.id')
            // ->whereNull('categories.parent_id')
            ->withCount([
                'products as total_sale' => function ($query) use ($from, $to) {
                    $query->join('seller_order_details', 'products.id', '=', 'seller_order_details.product_id')
                        ->whereBetween('seller_order_details.created_at', [$from, $to]) // Filter by seller_order_details.created_at
                        ->select(\DB::raw('SUM(seller_order_details.quantity)'));
                }
            ])
            ->orderByDesc('total_sale')
            ->having('total_sale', '>', 0)
            ->limit(5)
            ->get();

        // Eager load the brand data for the top categories
        $topParentCategories->load('childrenCategories');

        // Calculate the total quantity for each parent category including its children
        foreach ($topParentCategories as $parentCategory) {
            if (!blank($parentCategory->total_sale)) {
                $parentCategory->total_sale = $parentCategory->total_sale;  // not parent category wise total_sale count here, here count every single category sales.
                // $parentCategory->total_sale += $this->sumChildCategoriesQuantities($parentCategory, $from, $to);
                $parentCategory->name = $parentCategory->getTranslation('title');
                $parentCategory->image = $parentCategory->getThumbnailImage();
            }
        }

        return $topParentCategories;
    }

    private function sumChildCategoriesQuantities($category, $from, $to)
    {
        $totalQuantity = 0;

        foreach ($category->childrenCategories as $childCategory) {
            foreach ($childCategory->load('products')->products as $product) {
                $totalQuantity += $product->load('sellerOrderDetails')->sellerOrderDetails
                    ->whereBetween('created_at', [$from, $to]) // Filter by created_at
                    ->sum('quantity');
            }
        }

        return $totalQuantity;
    }

    // Get Top 5 Brands
    public function topBrands($from, $to)
    {
        $topBrands = SellerOrderDetails::whereBetween('seller_order_details.created_at', [$from, $to])
            ->select('products.brand_id', \DB::raw('SUM(seller_order_details.quantity) as brand_total_sale'))
            ->join('products', 'seller_order_details.product_id', '=', 'products.id')
            ->groupBy('products.brand_id')
            ->orderByDesc('brand_total_sale')
            ->having('brand_total_sale', '>', 0)
            ->orderBy('brand_total_sale', 'desc')
            ->pluck('brand_total_sale', 'brand_id')
            ->take(5)
            ->toArray();

        $data = [];

        foreach ($topBrands as $brand => $total_sale) {
            $brand = Brand::find($brand);

            if (!blank($brand)) {
                $item['id'] = $brand->id;
                $item['name'] = $brand->getTranslation('title');
                $item['image'] = $brand->getThumbnailImage();
                $item['total_sale'] = $total_sale;

                array_push($data, $item);
            }
        }

        return $data;
    }

    // Get Top 5 Seller
    public function topSeller($from, $to)
    {
        $orders = SellerOrder::whereBetween('created_at', [$from, $to])
            ->selectRaw('SUM(quantity) as seller_total_sale, seller_id')
            ->groupBy('seller_id')
            ->having('seller_total_sale', '>', 0)
            ->orderBy('seller_total_sale', 'desc')
            ->pluck('seller_total_sale', 'seller_id')
            ->take(5)
            ->toArray();

        $data = [];

        foreach ($orders as $seller => $total_sale) {
            $seller = User::find($seller);

            if (!blank($seller)) {
                $item['id'] = $seller->id;
                $item['name'] = $seller->full_name;
                $item['image'] = $seller->getAvatar();
                $item['total_sale'] = $total_sale;

                array_push($data, $item);
            }
        }

        return $data;
    }

    // Get Top 5 Products
    public function topProduct($from, $to)
    {
        $orders = SellerOrderDetails::whereBetween('created_at', [$from, $to])
            ->selectRaw('SUM(quantity) as product_total_sale, product_id')
            ->groupBy('product_id')
            ->having('product_total_sale', '>', 0)
            ->orderBy('product_total_sale', 'desc')
            ->pluck('product_total_sale', 'product_id')
            ->take(5)
            ->toArray();

        $data = [];

        foreach ($orders as $product => $total_sale) {
            $product = Product::find($product);

            if (!blank($product)) {
                $item['id'] = $product->id;
                $item['name'] = $product->getTranslation('short_title_for_dashboard');
                $item['slug'] = $product->slug;
                $item['image'] = $product->getThumbnailImage();
                $item['total_sale'] = $total_sale;

                array_push($data, $item);
            }
        }

        return $data;
    }
}
