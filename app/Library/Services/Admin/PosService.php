<?php

namespace App\Library\Services\Admin;

use Exception;
use Throwable;
use App\Library\Enum;
use App\Models\Order;
use App\Library\Helper;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use App\Models\SellerOrder;
use App\Models\ProductStock;
use App\Models\SellerOrderDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PosService extends BaseService
{
    private function actionHtml($row)
    {
        $actionHtml = '';

        if ($row->id) {
            $actionHtml .= '<a class="dropdown-item" href="' . route('admin.ams.category.edit', $row->id) . '" ><i class="far fa-edit"></i> Edit</a>';
            $actionHtml .= '<a class="dropdown-item text-danger" href="' . route('admin.ams.category.delete', $row->id) . '" ><i class="fas fa-trash-alt"></i> Delete</a>';
        }

        return '<div class="action dropdown">
                    <button class="btn btn2-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <i class="fas fa-tools"></i> Action
                    </button>
                    <div class="dropdown-menu">
                        ' . $actionHtml . '
                    </div>
                </div>';
    }

    private function getSwitch($row)
    {
        $is_check = $row->is_active ? "checked" : "";
        $route = "'" . route('admin.ams.category.change_status', $row->id) . "'";

        return '<div class="custom-control custom-switch">
                    <input type="checkbox"
                        onchange="changeStatus(event, ' . $route . ')"
                        class="custom-control-input"
                        id="primarySwitch_' . $row->id . '" ' . $is_check . ' >
                    <label class="custom-control-label" for="primarySwitch_' . $row->id . '"></label>
                </div>';
    }

    public function dataTable()
    {
        $query = Category::with('categoryType', 'operator', 'parent')->select('*');
        $data = $query->get();

        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('parent_id', function ($row) {
                    return $row->parent_id ? $row->parent->name : 'N/A';
                })
                ->editColumn('category_type_id', function ($row) {
                    return $row->categoryType->name;
                })
                ->editColumn('operator_id', function ($row) {
                    return $row?->operator?->full_name;
                })
                ->addColumn('action', function ($row) {
                    return $this->actionHtml($row);
                })
                ->editColumn('is_active', function ($row) {
                    return $this->getSwitch($row);
                })
                ->rawColumns(['action', 'is_active', 'category_type_id'])
                ->make(true);
    }

    public function store(array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = Category::create($data);

            return $this->handleSuccess('Successfully created');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function update(Category $category, array $data): bool
    {
        try {
            $data['operator_id'] = auth()->id();
            $this->data = $category->update($data);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function changeStatus(Category $category): bool
    {
        try {
            $this->data = $category->update(['is_active' => !$category->is_active]);

            return $this->handleSuccess('Successfully Updated');
        } catch (Exception $e) {
            Helper::log($e);

            return $this->handleException($e);
        }
    }

    public function storeOrder($data)
    {
        DB::beginTransaction();

        try {
            $findAddress = Address::where('user_id', $data['customerId'])->first();

            $totalQuantity = array_sum(array_map(function($product) {
                return $product['quantity'];
            }, $data['products']));

            $order = new Order();
            $order->invoice_id = generateInvoiceId();
            $order->customer_id = $data['customerId'];
            $order->operator_id = authId();
            $order->address_id = $findAddress ? $findAddress->id : '';
            $order->note = $data['note'];
            $order->quantity = $totalQuantity;
            $order->sub_total_amount = $data['subTotal'];
            $order->total_amount = $data['total'];
            $order->discount_amount = $data['discount'];
            $order->shipping_cost = $data['deliveryCharge'];
            $order->amount_to_be_collect = $data['due'];
            $order->collected_amount = $data['collection'];
            $order->order_status = Enum::ORDER_STATUS_TYPE_PROCESSING;
            $order->payment_status = $this->getPaymentStatus($data['collection'], $data['due']);
            $order->save();

            $sellerOrderData = [
                'order_id'         => $order->id,
                'seller_id'        => $data['products'][0]['seller_id'],
                'operator_id'      => authId(),
                'quantity'         => $totalQuantity,
                'sub_total_amount' => $data['subTotal'],
                'discount_amount'  => $data['discount'],
                'total_amount'     => $data['total'],
                'payment_date'     => now()->toDateString(),
                'payment_status'   => $this->getPaymentStatus($data['collection'], $data['due']),
            ];

            $seller_order = SellerOrder::create($sellerOrderData);

            foreach ($data['products'] as $item) {
                $findProduct = Product::where('id', $item['product_id'])->first();

                abort_unless($findProduct, 404);

                $findProduct->update(['current_stock' => $findProduct->current_stock - $item['quantity']]);

                // Check if the variant exists && stock available or not
                $findProductStock = ProductStock::where('id', $item['stock_id'])->first();

                abort_unless($findProductStock, 404);
                abort_if($findProductStock->current_stock < $item['quantity'], 403);

                // Update stock
                $findProductStock->update(['current_stock' => $findProductStock->current_stock - $item['quantity']]);

                $salePrice = $findProduct->calculatePriceAfterDiscount($item['price']);

                $sellerOrderDetailData = [
                    'seller_order_id'  => $seller_order->id,
                    'product_id'       => $item['product_id'],
                    'stock_variant_id' => $findProductStock?->id ?? null,
                    'quantity'         => $item['quantity'],
                    'product_price'    => $item['price'],
                    'sale_price'       => $salePrice,
                    'discount_type'    => $findProduct?->productDetails?->discount_type ?? null,
                    'discount'         => $findProduct?->productDetails?->discount ?? 0,
                ];

                SellerOrderDetails::create($sellerOrderDetailData);
            }

            // Payment
            foreach ($data['payments'] as $orderPayment) {
                $payment['type'] = Enum::PAYMENT_TYPE_SALE;
                $payment['order_id'] = $order->id;
                $payment['operator_id'] = authId();
                $payment['payment_method'] = $orderPayment['type'];
                $payment['amount'] = $orderPayment['amount'];
                $payment['transaction_id'] = $orderPayment['transaction_id'];
                $payment['note'] = $data['note'];
                $payment['payment_status'] = Enum::PAYMENT_STATUS_FAILED;

                Payment::create($payment);
            }

            DB::commit();

            return $this->handleSuccess('Successfully created');
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->handleException($e);
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
