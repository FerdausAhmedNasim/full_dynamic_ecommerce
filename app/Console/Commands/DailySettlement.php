<?php

namespace App\Console\Commands;

use Throwable;
use App\Models\User;
use App\Library\Enum;
use App\Models\Advertise;
use App\Models\SellerOrder;
use App\Models\BalanceHistory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Settlement as ModelSettlement;

/**
 * Class CleanCache
 *
 * Clear all caches of the application
 *
 * @package App\Console\Commands
 */
class DailySettlement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settlement:create_daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create daily settlement';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * return self
     */
    public function handle()
    {
        $today = now()->format('d');
        $today = 1;
        $startDate = now()->toDateString();
        $endDate = now()->toDateString();

        $exists = ModelSettlement::where('start_date', $startDate)
                                ->where('end_date', $endDate)
                                ->first();

        if ($exists) {
            $this->info('Settlement already created for ' . $startDate . ' :(');

            return;
        }

        $sellerOrderIds = SellerOrder::where('seller_orders.payment_status', 'paid')
                            ->whereBetween('payment_date', [$startDate, $endDate])
                            ->get()
                            ->map(function ($sellerOrder) {
                                return ['seller_order_id' => $sellerOrder->id];
                            })
                            ->toArray();

        $query = SellerOrder::where('seller_orders.payment_status', 'paid')
                                ->whereBetween('payment_date', [$startDate, $endDate]);

        $sellerOrders = $query->select('seller_id', DB::raw('SUM(sub_total_amount) as total_sale'), DB::raw('SUM(commission_amount) as commission'))
                                ->groupBy('seller_id')
                                ->get();

        DB::beginTransaction();

        try {
            foreach ($sellerOrders as $sellerOrder) {
                $adQuery = Advertise::where('seller_id' , $sellerOrder->seller_id)
                                    ->where('status', Enum::AD_STATUS_ACTIVE)
                                    ->whereBetween('end_date', [$startDate, $endDate]);

                $settlement = ModelSettlement::create([
                    'seller_id' => $sellerOrder->seller_id,
                    'total_sale' => $sellerOrder->total_sale,
                    'commission' => $sellerOrder->commission,
                    'ad_cost' => $adQuery->sum('amount'),
                    'amount' => $sellerOrder->total_sale - ($sellerOrder->commission + $adQuery->sum('amount')),
                    'date' => now()->format('Y-m-d'),
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $settlement->orders()->createMany($sellerOrderIds);

                $user = User::find($sellerOrder->seller_id);

                BalanceHistory::create([
                    'seller_id' => $settlement->seller_id,
                    'amount' => $settlement->amount,
                    'type' => 'settlement',
                    'dr_cr' => 'cr',
                ]);

                $user->balance += $settlement->amount;
                $user->save();
            }

            DB::commit();
         } catch (Throwable $e) {
             DB::rollBack();
             Log::error('Settlement error: ' . $e->getMessage());
                $this->error('Something went wrong! for ' . now()->format('d-m-Y') . ' :(');
         }

        Log::warning('Settlement successfully created for ' . now()->format('d-m-Y') . ' :)');

        $this->info('Settlement successfully created for ' . now()->format('d-m-Y') . ' :)');
    }
}
