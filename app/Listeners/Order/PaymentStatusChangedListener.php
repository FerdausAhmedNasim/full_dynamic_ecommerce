<?php

namespace App\Listeners\Order;

use App\Library\Enum;
use App\Library\Helper;
use App\Models\EmailTemplate;
use App\Events\Order\StatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Order\PaymentStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Library\Services\Admin\EmailService;

class PaymentStatusChangedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\StatusChanged  $event
     * @return void
     */
    public function handle(PaymentStatusChanged $event)
    {
        $sellerOrder = $event->order;

        $allStatus = $sellerOrder->order->sellerOrders->pluck('payment_status')->toArray();

        if (array_unique($allStatus) === array($sellerOrder->order_status)) {
            $sellerOrder->order->update(['payment_status' => $sellerOrder->payment_status]);
        } elseif (in_array(Enum::ORDER_PAYMENT_STATUS_PAID, $allStatus)) {
            $sellerOrder->order->update(['payment_status' => Enum::ORDER_PAYMENT_STATUS_PARTIAL]);
        } else {
            $sellerOrder->order->update(['payment_status' => Enum::ORDER_PAYMENT_STATUS_UNPAID]);
        }

       // logger($sellerOrder);

        // $email_setting = EmailTemplate::where('key', Enum::EMAIL_ORDER_STATUS_CHANGE)->first();

        // $subject = $email_setting->subject;
        // $message = $email_setting->message;

        // $shortcodes = explode(',', $email_setting->shortcodes);
        // $shortcode_values = [];

        // foreach ($shortcodes as $shortcode) {
        //     switch ($shortcode) {
        //         case 'invoice_id':
        //             $shortcode_values['invoice_id'] = $sellerOrder->order->invoice_id;

        //             break;
        //         case 'status':
        //             $shortcode_values['status'] = $sellerOrder->order_status;

        //             break;
        //         default:
        //     }
        // }

        // $message = Helper::replaceMessageWithShortcodes($message, $shortcode_values);

        // $data = [
        //     'email'   => $sellerOrder->order->customer->email,
        //     'subject' => $subject,
        //     'message' => $message,
        // ];

        // EmailService::sendMail($data);
    }
}
