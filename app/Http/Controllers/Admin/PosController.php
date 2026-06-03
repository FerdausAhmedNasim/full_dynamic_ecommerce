<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\User;
use App\Library\Enum;
use App\Models\Brand;
use App\Models\Order;
use App\Library\Helper;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\PosService;

class PosController extends Controller
{
    private $pos_service;

    public function __construct(PosService $pos_service)
    {
        $this->pos_service = $pos_service;
    }

    public function index(Request $request)
    {
        return view('admin.pages.pos.index');
    }

    public function quotation(Request $request)
    {
        return view('admin.pages.pos.quotation');
    }

    public function getInitialData()
    {
        $brands = Brand::with('operator', 'languages')->get();
        $paymentMethods = getDropdown(Enum::CONFIG_DROPDOWN_PAYMENT_METHOD);
        $genders = getDropdown(Enum::CONFIG_DROPDOWN_GENDER);
        $categories = Category::with('operator', 'parent', 'languages')->active()->get();
        $vatAmount = settings('vat_amount') ? settings('vat_amount') : 0;
        $authUserName = authUser()->full_name;
        $date = getFormattedDate(now());
        $currency = settings('currency_symbol') ? settings('currency_symbol') : '$';
        $countries = Helper::getCountries();
        $customerTypes = [Enum::CUSTOMER_TYPE_INDIVIDUAL, Enum::CUSTOMER_TYPE_BUSINESS];

        return [
            'brands'         => $brands,
            'branches'       => [],
            'categories'     => $categories,
            'paymentMethods' => $paymentMethods,
            'vatAmount'      => $vatAmount,
            'authUserName'   => $authUserName,
            'date'           => $date,
            'currency'       => $currency,
            'genders'        => $genders,
            'countries'      => $countries,
            'customerTypes'  => $customerTypes,
            'isAdmin'        => true,
            'isMultiBranchEnabled' => false
        ];
    }

    public function storeCustomer(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required',
            'phone'     => 'required',
        ]);

        try {
            $user = new User();
            $user->first_name = $request->full_name;
            $user->last_name = "";
            $user->email = $request->email;
            $user->password = bcrypt(config('app.admin_password'));
            $user->user_type = Enum::USER_TYPE_CUSTOMER;
            $user->status = Enum::USER_STATUS_ACTIVE;
            $user->phone = $request->country_code . '-' . $request->phone;
            $user->gender = $request->gender;
            $user->description = $request->description;
            $user->address = $request->address;
            $user->gender = $request->gender;
            $user->operator_id = authId();
            $user->save();

            return response()->json(['status' => 'success'], 200);
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            return response()->json(['status' => 'failed'], 400);
        }
    }

    public function getCustomers()
    {
        $itemsPerPage = request('per_page');
        $query = User::where('user_type', Enum::USER_TYPE_CUSTOMER)->where('status', Enum::USER_STATUS_ACTIVE);

        if (request('search')) {
            $query->whereLike(['first_name', 'last_name', 'email', 'phone'], request('search'));
        }

        $customers = $query->paginate($itemsPerPage);

        return response()->json(['data' => $customers], 200);
    }

    public function getCustomerDue($customerId)
    {
        $dueAmount = Order::where(['customer_id' => $customerId])->sum('amount_to_be_collect');

        return response()->json(['dueAmount' => $dueAmount], 200);
    }

    public function getStocks()
    {
        $itemsPerPage = request('per_page');

        $query = Product::with('productLanguages', 'productStock', 'productStocks', 'productDetails', 'brand.languages')
                ->where('current_stock', '>', 0);
        
        if (request('search')) {
            $query->whereHas('productLanguages', function ($q) {
                $q->where('title', 'like', '%' . request('search') . '%');
            });
        }

        $brands = json_decode(request('brands'));
        $categories = json_decode(request('categories'));

        if (count($brands)) {
            $query->whereIn('brand_id', $brands);
        }

        if (count($categories)) {
            $query->whereIn('category_id', $categories);
        }

        $products = $query->paginate($itemsPerPage);

        return response()->json(['data' => $products], 200);
    }

    public function placeOrder(Request $request)
    {
        $result = $this->pos_service->storeOrder($request->all());

        if ($result) {
            return response()->json(['status' => 'success'], 200);
        }

        return response()->json(['status' => 'failed'], 400);
    }

    public function createQuotation(Request $request)
    {
        DB::beginTransaction();

        $branchId = authUser()->employeeBranch?->branch_id ?? $request->branch_id;

        try {
            $order = new Order();
            $order->invoice_id = generateInvoiceId();
            $order->type = Enum::ORDER_TYPE_QUOTATION;
            $order->customer_id = $request->customerId;
            $order->branch_id = $branchId;
            $order->operator_id = authId();
            $order->note = $request->note;
            $order->sub_total_amount = $request->subTotal;
            $order->total_amount = $request->total;
            $order->vat_amount = $request->vat;
            $order->discount_amount = $request->discount;
            $order->packaging_cost = $request->packagingCharge;
            $order->delivery_cost = $request->deliveryCharge;
            $order->order_status = Enum::ORDER_STATUS_TYPE_PROCESSING;
            $order->payment_status = Enum::ORDER_PAYMENT_STATUS_UNPAID;
            $order->save();

            $order->createDetails($request->stocks);

            DB::commit();

            return response()->json(['status' => 'success'], 200);
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return response()->json(['status' => 'failed'], 400);
        }
    }

    public function getPaymentStatus($collection, $due)
    {
        if ($collection == 0) {
            $paymentStatus = Enum::ORDER_PAYMENT_STATUS_UNPAID;
        } elseif ($due == 0) {
            $paymentStatus = Enum::ORDER_PAYMENT_STATUS_PAID;
        } else {
            $paymentStatus = Enum::ORDER_PAYMENT_STATUS_PARTIAL;
        }

        return $paymentStatus;
    }
}
