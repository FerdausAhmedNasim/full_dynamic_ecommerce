<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'invoice_id',
        'customer_id',
        'operator_id',
        'address_id',
        'order_person_name',
        'order_person_phone',
        'order_person_address',
        'shipping_area',
        'note',
        'quantity',
        'sub_total_amount',
        'total_amount',
        'discount_amount',
        'return_amount',
        'shipping_cost',
        'penalty_amount',
        'collected_amount',
        'amount_to_be_collect',
        'order_status',
        'payment_status',
        'payment_type',
        'payment_details',
    ];


    /*===================== Start Eloquent Relations ======================*/
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sellerOrders()
    {
        return $this->hasMany(SellerOrder::class, 'order_id', 'id');
    }

    // public function orderDetails()
    // {
    //     return $this->hasMany(OrderDetails::class);
    // }

    public function paymentDetails()
    {
        return $this->hasOne(Payment::class, 'order_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // public function stocks()
    // {
    //     return $this->hasMany(Stock::class, 'order_id', 'id');
    // }

    public function returns()
    {
        return $this->hasMany(OrderReturn::class, 'seller_order_id', 'id');
    }

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
    /*===================== End Eloquent Relations ======================*/


    // Get Auth User Branch Wise Sales
    public static function getAuthUserBranchWiseSale($user, $from, $to)
    {
        $query = self::where('type', Enum::ORDER_TYPE_SALE)
            ->whereBetween('created_at', [$from, $to]);

        if ($user->isSuperAdmin() || $user->isAdmin()) {
            $query;
        } elseif ($user->isEmployee()) {
            $query->where('branch_id', $user->employeeBranch->id);
        } else {
            return null;
        }

        return $query;
    }

    // Get Total Sales
    public static function getTotalSales($user, $from, $to)
    {
        $query = self::getAuthUserBranchWiseSale($user, $from, $to);

        return $query->sum('total_amount');
    }

    // Get Total Due
    public static function getTotalDue($user, $from, $to)
    {
        $query = self::getAuthUserBranchWiseSale($user, $from, $to);

        return $query->sum('due_amount');
    }

    // Get Total Collection
    public static function getTotalCollection($user, $from, $to)
    {
        return self::getTotalSales($user, $from, $to) - self::getTotalDue($user, $from, $to);
    }


    public static function getOrder()
    {
        $startDate = now()->startOfMonth()->subMonths(11);
        $endDate = now()->addMonth();

        return self::whereBetween('created_at', [$startDate, $endDate])->get();
    }

    public function getInvoiceAttribute()
    {
        $invoice_prefix = settings('invoice_prefix') ? settings('invoice_prefix') : 'pos';

        return $invoice_prefix . '-' . $this->invoice_id;
    }

    public function createDetails($stocks, $isOrder = false)
    {
        $orderDetails = [];

        foreach ($stocks as $stock) {
            if ($isOrder) {
                $currentStock = Stock::find($stock['stock_id']);
                $currentStock->quantity = $currentStock->quantity - $stock['quantity'];
                $currentStock->save();
            }

            $orderDetails[] = [
                'product_id' => $stock['product_id'],
                'quantity'   => $stock['quantity'],
                'sale_price' => $stock['price'],
                'stock_id'   => $stock['stock_id'],
            ];
        }

        $this->orderDetails2()->createMany($orderDetails);
    }

    public function createPayments($payments, $branchId)
    {
        $paymentDetails = [];

        foreach ($payments as $payment) {
            if ($payment['amount'] <= 0) {
                continue;
            }

            $paymentDetails[] = [
                'type'           => Enum::PAYMENT_TYPE_SALE,
                'operator_id'    => authId(),
                'payment_method' => $payment['type'],
                'amount'         => $payment['amount'],
                'transaction_id' => $payment['transaction_id'],
                'order_status'   => $this->order_status,
            ];
        }

        $this->payments()->createMany($paymentDetails);

        if (count($paymentDetails)) {
            Account::create([
                'branch_id'   => $branchId,
                'operator_id' => authId(),
                'amount'      => $this->getAmount($paymentDetails)
            ]);
        }
    }

    public function getAmount($paymentDetails)
    {
        $totalAmount = array_map(function ($payment) {
            return isset($payment['amount']) && is_numeric($payment['amount']) ? floatval($payment['amount']) : 0;
        }, $paymentDetails);

        return array_sum($totalAmount);
    }

    public static function getTotalOrderByDate($from, $to)
    {
        return self::whereBetween('created_at', [$from, $to]);
    }

    public static function getTotalSalesByDate($from, $to)
    {
        $total_amount = self::getTotalOrderByDate($from, $to)->where('order_status', Enum::ORDER_STATUS_TYPE_DELIVERED)->sum('total_amount');
        $shipping_cost = self::getTotalOrderByDate($from, $to)->where('order_status', Enum::ORDER_STATUS_TYPE_DELIVERED)->sum('shipping_cost');

        return $total_amount - $shipping_cost;
    }

    /*==================== Helper Functions =========================*/
}
