<?php

namespace Database\Seeders\SystemData;

use App\Library\Enum;
use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = self::getRecords();

        foreach ($records as $record) {
            EmailTemplate::create($record);
        }
    }

    private static function getRecords()
    {
        return [
            //=====--- Ticket --=========//
            [
                'name'       => 'Ticket Created',
                'key'        => Enum::EMAIL_TICKET_CREATE,
                'subject'    => 'You have been opened a ticket',
                'message'    => self::getContent(Enum::EMAIL_TICKET_CREATE),
                'shortcodes' => 'receiver_name,ticket_id,reply_message',
            ],
            [
                'name'       => 'Ticket Assigned',
                'key'        => Enum::EMAIL_TICKET_ASSIGN,
                'subject'    => 'You have been Assigned To a ticket',
                'message'    => self::getContent(Enum::EMAIL_TICKET_ASSIGN),
                'shortcodes' => 'assign_to',
            ],
            [
                'name'       => 'Ticket Replied',
                'key'        => Enum::EMAIL_TICKET_REPLY,
                'subject'    => 'You have been Replied a ticket',
                'message'    => self::getContent(Enum::EMAIL_TICKET_REPLY),
                'shortcodes' => 'reply_message,reply_to',
            ],

            [
                'name'       => 'Order Create',
                'key'        => Enum::EMAIL_ORDER_CREATE,
                'subject'    => 'A new Order is Created',
                'message'    => self::getContent(Enum::EMAIL_ORDER_CREATE),
                'shortcodes' => 'invoice_id,customer_name,seller_name',
            ],
            [
                'name'       => 'Order Status Change',
                'key'        => Enum::EMAIL_ORDER_STATUS_CHANGE,
                'subject'    => 'Your order status is changed',
                'message'    => self::getContent(Enum::EMAIL_ORDER_STATUS_CHANGE),
                'shortcodes' => 'invoice_id,note,customer_name,seller_name,status',
            ],
            [
                'name'       => 'Return Request Sent',
                'key'        => Enum::EMAIL_PRODUCT_RETURN,
                'subject'    => 'You have new Return request',
                'message'    => self::getContent(Enum::EMAIL_PRODUCT_RETURN),
                'shortcodes' => 'invoice_id,customer_name,seller_name, product_name',
            ],
            [
                'name'       => 'Return Status Change',
                'key'        => Enum::EMAIL_RETURN_STATUS_CHANGE,
                'subject'    => 'Your Return request is Changed',
                'message'    => self::getContent(Enum::EMAIL_RETURN_STATUS_CHANGE),
                'shortcodes' => 'invoice_id,customer_name,seller_name,status',
            ],
            // [
            //     'name'       => 'Seller Status Change',
            //     'key'        => Enum::EMAIL_SELLER_STATUS_CHANGE,
            //     'subject'    => 'Your Status is Changed',
            //     'message'    => self::getContent(Enum::EMAIL_SELLER_STATUS_CHANGE),
            //     'shortcodes' => 'seller_name,status',
            // ],
            // [
            //     'name'       => 'Shop Status Change',
            //     'key'        => Enum::EMAIL_SHOP_STATUS_CHANGE,
            //     'subject'    => 'Your Shop Status is Changed',
            //     'message'    => self::getContent(Enum::EMAIL_SHOP_STATUS_CHANGE),
            //     'shortcodes' => 'shop_name,seller_name,status',
            // ],
            // [
            //     'name'       => 'Payout Request',
            //     'key'        => Enum::EMAIL_PAYOUT_REQUEST,
            //     'subject'    => 'A new Payout Request Sent',
            //     'message'    => self::getContent(Enum::EMAIL_PAYOUT_REQUEST),
            //     'shortcodes' => 'amount,seller_name',
            // ],
            [
                'name'       => 'Customer Status Change',
                'key'        => Enum::EMAIL_CUSTOMER_STATUS_CHANGE,
                'subject'    => 'Your Status is Changed',
                'message'    => self::getContent(Enum::EMAIL_CUSTOMER_STATUS_CHANGE),
                'shortcodes' => 'customer_name,status',
            ],
            // [
            //     'name'       => 'Settlement Created',
            //     'key'        => Enum::EMAIL_SETTLEMENT_CREATE,
            //     'subject'    => 'Settlement has been Opened',
            //     'message'    => self::getContent(Enum::EMAIL_SETTLEMENT_CREATE),
            //     'shortcodes' => 'settlement_date,seller_name,total_sale,ad_cost,commission,amount',
            // ],
        ];
    }

    private static function getContent($key)
    {
        return file_get_contents(__DIR__ . '/emails/' . $key . '.php');
    }
}
