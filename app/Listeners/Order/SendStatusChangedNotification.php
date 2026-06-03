<?php

namespace App\Listeners\Order;

use App\Library\Enum;
use App\Library\Helper;
use App\Models\EmailTemplate;
use App\Events\Order\StatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Library\Services\Admin\EmailService;

class SendStatusChangedNotification
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
    public function handle(StatusChanged $event)
    {
        $order = $event->order;

        $allStatus = $order->pluck('order_status')->toArray();

        if (array_unique($allStatus) === array($order->order_status)) {
            $order->update(['order_status' => $order->order_status]);
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
        //             $shortcode_values['invoice_id'] = $order->invoice_id;

        //             break;
        //         case 'status':
        //             $shortcode_values['status'] = $sellerOrder->order_status;

        //             break;
        //         default:
        //     }
        // }

        // $message = Helper::replaceMessageWithShortcodes($message, $shortcode_values);

        // $data = [
        //     'email'   => $order->customer->email,
        //     'subject' => $subject,
        //     'message' => $message,
        // ];

        // EmailService::sendMail($data);
    }
}
