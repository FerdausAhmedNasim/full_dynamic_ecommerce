<?php

namespace App\Http\Controllers\Seller;

use App\Models\User;
use App\Library\Enum;
use App\Models\Order;
use App\Library\Response;
use Illuminate\View\View;
use App\Models\OrderReturn;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\ReturnService;

class ReturnController extends Controller
{
    use ApiResponse;
    private $return_service;

    public function __construct(ReturnService $return_service)
    {
        $this->return_service = $return_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_request = $request->only(['seller','status']);

            return $this->return_service->dataTable($filter_request);
        }

        $returns =  User::with('operator', 'store.storeLanguage')
                    ->whereIn('users.user_type', [Enum::USER_TYPE_SELLER, Enum::USER_TYPE_MODERATOR])
                    ->where('status', Enum::USER_STATUS_ACTIVE)
                    ->get();

        return view('seller.pages.return.index', [
            'sellers' => $returns,
        ]);
    }

    public function getSale(Request $request)
    {
        $this->validate($request, [
            'invoice_id' => 'required|exists:orders,invoice_id',
        ]);

        $order = Order::where('invoice_id', $request->invoice_id)->where('type', Enum::ORDER_TYPE_SALE)->first();

        if (!$order) {
            return Response::error(__($request->invoice_id . ' Not Exists.'));
        } else {
            return $this->successResponse("Successfully Find", $order->id);
        }
    }


    public function show(OrderReturn $order_return): View
    {
        return view('seller.pages.return.show', [
            'order_return'   => $order_return->load('sellerOrder.seller', 'operator'),
            'return_details' => $order_return->returnDetails->load('product'),
            'attachments'    => $order_return->attachments,
        ]);
    }

    public function update(Request $request, OrderReturn $order_return)
    {
        $result = $this->return_service->updateStatus($request->status, $order_return);

        if ($result) {
            return redirect()->route('seller.return.index')->with('success', $this->return_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->return_service->message);
    }

}
