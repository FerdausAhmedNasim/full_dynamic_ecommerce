<?php

namespace App\Console\Commands;

use Throwable;
use App\Models\User;
use App\Library\Enum;
use App\Models\Advertise;
use App\Models\SellerOrder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Settlement as ModelsSettlement;

/**
 * Class CleanCache
 *
 * Clear all caches of the application
 *
 * @package App\Console\Commands
 */
class Settlement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settlement:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create settlement';

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
        //$today = 1;
        $startDate = '';
        $endDate = '';

        if (settings('first_settlement_date') || settings('second_settlement_date')) {
            Log::error('Settlement setting error: Settlement setting is not set yet! :( for ' . now()->format('d-m-Y'));
            $this->info('Settlement setting is not set yet for ' . now()->format('d-m-Y') . ' :)');

            return;
        }

        $query = SellerOrder::where('seller_orders.payment_status', 'Paid');

        if ($today == settings('first_settlement_date')) {
            $startDate = now()->subMonth()->startOfMonth()->addDays(15)->toDateString();
            $endDate = now()->subMonth()->endOfMonth()->toDateString();

            $query->whereBetween('payment_date', [$startDate, $endDate]);

        } elseif ($today == settings('second_settlement_date')) {
            $startDate = now()->startOfMonth()->toDateString();
            $endDate = now()->startOfMonth()->addDays(14)->toDateString();

            $query->whereBetween('payment_date', [$startDate, $endDate]);
        }

        $sellerOrderIds = SellerOrder::where('seller_orders.payment_status', 'paid')
                            ->whereBetween('payment_date', [$startDate, $endDate])
                            ->get()
                            ->map(function ($sellerOrder) {
                                return ['seller_order_id' => $sellerOrder->id];
                            })
                            ->toArray();

        $sellerOrders = $query->select('seller_id', DB::raw('SUM(sub_total_amount) as total_sale'), DB::raw('SUM(commission_amount) as commission'))
                                ->groupBy('seller_id')
                                ->get();

       // DB::beginTransaction();

       // try {
            foreach ($sellerOrders as $sellerOrder) {
                // $exits = ModelsSettlement::where('seller_id', $sellerOrder->seller_id)
                //                     ->where('date', now()->format('Y-m-d'))
                //                     ->first();

                // if ($exits) {
                //     Log::warning('Settlement already created for seller ' . $exits->seller->full_name . ' of ' . now()->format('d-m-Y') . ' ;)');
                //     $this->info('Settlement already created for ' . now()->format('d-m-Y') . ' ;)');
                //     break;
                // }

                $adQuery = Advertise::where('seller_id' , $sellerOrder->seller_id)
                                    ->where('status', Enum::AD_STATUS_ACTIVE);

                if ($today == settings('first_settlement_date')) {
                    $startDate = now()->subMonth()->startOfMonth()->addDays(15)->toDateString();
                    $endDate = now()->subMonth()->endOfMonth()->toDateString();

                    $adQuery->whereBetween('end_date', [$startDate, $endDate]);

                } elseif ($today == settings('second_settlement_date')) {
                    $startDate = now()->startOfMonth()->toDateString();
                    $endDate = now()->startOfMonth()->addDays(14)->toDateString();

                    $adQuery->whereBetween('end_date', [$startDate, $endDate]);
                }

                $settlement = ModelsSettlement::create([
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
                $user->balance += $settlement->amount;
                $user->save();
            }

           // DB::commit();
        // } catch (Throwable $e) {
        //     DB::rollBack();
        //     Log::error($e->getMessage());
        // }

        Log::warning('Settlement successfully created for ' . now()->format('d-m-Y') . ' :)');

        $this->info('Settlement successfully created for ' . now()->format('d-m-Y') . ' :)');
    }
}
