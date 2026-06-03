<?php

namespace App\Http\Controllers\Public\Dashboard;

use App\Library\Enum;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\SellerOrder;
use App\Http\Controllers\Controller;

class MemberDashboard extends Controller
{
    public function index()
    {
        $customerId = authUser()->id;

        return view('public.member_dashboard.dashboard.index', [
            'total_order'            => Order::where('customer_id', authId())->get()->count(),
            'total_processing_order' => Order::where('customer_id', authId())->where('order_status', Enum::ORDER_STATUS_TYPE_PROCESSING)->get()->count(),
            'total_wishlist'         => Wishlist::where('user_id', authId())->get()->count(),
            'orders'                 => SellerOrder::with('order', 'return', 'sellerOrderDetails')
                                    ->whereHas('order', function ($query) use ($customerId) {
                                        $query->where('customer_id', $customerId);
                                    })
                                    ->latest()
                                    ->paginate(6),
        ]);
    }
}
