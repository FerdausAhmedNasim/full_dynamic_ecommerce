<?php

namespace App\Http\Controllers\Admin\User\Seller;

use App\Models\Role;
use App\Models\User;
use App\Library\Enum;
use App\Models\Store;
use App\Library\Helper;
use App\Models\BankAccount;
use App\Models\OrderReturn;
use App\Models\SellerOrder;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\BalanceHistory;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\User\SellerService;
use App\Http\Requests\Admin\User\Seller\CreateRequest;
use App\Http\Requests\Admin\User\Seller\UpdateRequest;

class SellerController extends Controller
{
    use ApiResponse;
    private $seller_service;

    public function __construct(SellerService $seller_service)
    {
        $this->seller_service = $seller_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_request = $request->only(['status', 'is_deleted']);

            return $this->seller_service->dataTable($filter_request);
        }

        return view('admin.pages.user.seller.index');
    }

    public function show(User $user)
    {
        abort_unless($user, 404);

        $totalWithdraw = BalanceHistory::where('seller_id', $user->id)
                    ->whereIn('type', [Enum::BALANCE_HISTORY_STATUS_PAYOUT, Enum::BALANCE_HISTORY_STATUS_SEND_MONEY])
                    ->sum('amount');

        $totalSales = SellerOrder::where('seller_id', $user->id)
                        ->where('order_status', Enum::ORDER_STATUS_TYPE_DELIVERED)
                        ->sum('total_amount');

        $totalOrders = SellerOrder::where('seller_id', $user->id)->count();

        $totalOrderReturns = OrderReturn::join('seller_orders', 'order_returns.seller_order_id', '=', 'seller_orders.id')
                    ->where('seller_orders.seller_id', $user->id)
                    ->where('status', Enum::RETURN_STATUS_APPROVED)
                    ->sum('order_returns.total_amount');


        $ratingCounts = ProductReview::join('products', 'product_reviews.product_id', '=', 'products.id')
                    ->where('products.seller_id', $user->id)
                    ->active()
                    ->selectRaw('product_reviews.rating, COUNT(*) as count')
                    ->groupBy('product_reviews.rating')
                    ->pluck('count', 'rating')
                    ->toArray();

        // Initialize data array
        $data = [];

        // Assign counts to data array with default value of 0 if no count found
        for ($i = 1; $i <= 5; $i++) {
            $data['rate_' . $i] = $ratingCounts[$i] ?? 0;
        }

        $ratings = $data;

        $totalRating = array_sum($ratings);

        $averageRating = ProductReview::join('products', 'product_reviews.product_id', '=', 'products.id')
                    ->where('products.seller_id', $user->id)
                    ->active()
                    ->selectRaw('AVG(product_reviews.rating) as average_rating')
                    ->first()->average_rating;

        return view('admin.pages.user.seller.show', [
            'user' => $user->load('store.storeLanguage'),
            'totalWithdraw' => $totalWithdraw,
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'totalOrderReturns' => $totalOrderReturns,
            'ratings' => $ratings,
            'totalRating' => $totalRating,
            'averageRating' => $averageRating,
        ]);
    }

    public function showDetails(User $user)
    {
        return view('admin.pages.user.seller.partials.details.details', compact('user'));
    }

    public function showStore(User $user)
    {
        return view('admin.pages.user.seller.partials.details.store', [
            'user' => $user->load('store.storeLanguage')
        ]);
    }

    public function showBankDetails(User $user)
    {
        $banks = BankAccount::with("getBanks")->where("seller_id", $user->id)->get();

        return view('admin.pages.user.seller.partials.details.banks', [
            'banks' => $banks,
            'user' => $user
        ]);
    }

    public function showCreateForm()
    {
        return view('admin.pages.user.seller.create', [
            'countries' => Helper::getCountries(),
            'genders'   => getDropdown(Enum::CONFIG_DROPDOWN_GENDER),
            'roles'     => Role::getSellerRoles(),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->seller_service->createSeller($request->validated());

        if ($result) {
            return redirect()->route('admin.user.seller.index')->with('success', $this->seller_service->message);
        }

        return back()->withInput(request()->all())->with('error', $this->seller_service->message);
    }

    public function showUpdateForm(User $user)
    {
        abort_unless($user, 404);

        return view('admin.pages.user.seller.edit', [
            'seller'    => $user->load('store.storeLanguage'),
            'countries' => Helper::getCountries(),
            'genders'   => getDropdown(Enum::CONFIG_DROPDOWN_GENDER),
            'roles'     => Role::getSellerRoles(),
            'user'      => $user,
        ]);
    }

    public function update(User $user, UpdateRequest $request)
    {
        abort_unless($user, 404);
        $result = $this->seller_service->updateSeller($user, $request->validated());

        if ($result) {
            return redirect()->route('admin.user.seller.index')->with('success', $this->seller_service->message);
        }

        return back()->withInput(request()->all())->with('error', $this->seller_service->message);
    }

    public function changeShopStatus(Request $request, Store $store)
    {
        abort_unless($store, 404);
        $result = $this->seller_service->changeShopStatus($store);

        if ($result) {
            return redirect()->route('admin.user.seller.index')->with('success', $this->seller_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->seller_service->message);
    }
}
