<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Library\Enum;
use App\Models\Order;
use Illuminate\Console\Command;

class DeleteOldUnpaidOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:delete-old-unpaid';

     /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all orders placed more than 7 days ago with an unpaid status, including related seller orders and their details';

    /**
     * Execute the console command.
     *
     * return self
     */
    public function handle()
    {
        $cutoffDate = Carbon::now()->subDays(7);

        $orders = Order::where('payment_status', Enum::ORDER_PAYMENT_STATUS_UNPAID)
            ->where('created_at', '<', $cutoffDate)
            ->with(['sellerOrders.sellerOrderDetails'])
            ->get();

        $deletedOrdersCount = 0;
        $deletedSellerOrdersCount = 0;
        $deletedSellerOrderDetailsCount = 0;

        foreach ($orders as $order) {
            foreach ($order->sellerOrders as $sellerOrder) {
                $deletedSellerOrderDetailsCount += $sellerOrder->sellerOrderDetails()->count();
                $sellerOrder->sellerOrderDetails()->delete();

                $deletedSellerOrdersCount++;
                $sellerOrder->delete();
            }

            $order->delete();
            $deletedOrdersCount++;
        }

        $this->info("Deleted {$deletedOrdersCount} unpaid orders older than 7 days.");
        $this->info("Deleted {$deletedSellerOrdersCount} related seller orders.");
        $this->info("Deleted {$deletedSellerOrderDetailsCount} related seller order details.");
    }
}
