<?php

namespace Database\Seeders\DemoData;

use App\Library\Enum;
use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductLanguage;
use App\Models\SellerOrder;
use App\Models\SellerOrderDetails;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        //Product-1
        $data = [
            'invoice_id'  => '121211',
            'customer_id' => User::whereUserType(Enum::USER_TYPE_CUSTOMER)->first()?->id,
            'address_id' => Address::first()?->id,
            'operator_id' => 1,
            'quantity' => 11,
        ];

        $order1 = Order::create($data);

        $sellerOrder1 = new SellerOrder();
        $sellerOrder1->order_id = $order1->id;
        $sellerOrder1->operator_id = 1;
        $sellerOrder1->seller_id = 3;
        $sellerOrder1->quantity = 7;
        $sellerOrder1->save();

            $sellerOrderDetails1 = new SellerOrderDetails();
            $sellerOrderDetails1->seller_order_id = $sellerOrder1->id;
            $sellerOrderDetails1->product_id = 1;
            $sellerOrderDetails1->sale_price = 100;
            $sellerOrderDetails1->quantity = 5;
            $sellerOrderDetails1->save();

            $sellerOrderDetails1 = new SellerOrderDetails();
            $sellerOrderDetails1->seller_order_id = $sellerOrder1->id;
            $sellerOrderDetails1->product_id = 2;
            $sellerOrderDetails1->sale_price = 100;
            $sellerOrderDetails1->quantity = 2;
            $sellerOrderDetails1->save();

        $sellerOrder2 = new SellerOrder();
        $sellerOrder2->order_id = $order1->id;
        $sellerOrder2->operator_id = 1;
        $sellerOrder2->seller_id = 4;
        $sellerOrder2->quantity = 4;
        $sellerOrder2->save();

            $sellerOrderDetails1 = new SellerOrderDetails();
            $sellerOrderDetails1->seller_order_id = $sellerOrder2->id;
            $sellerOrderDetails1->product_id = 1;
            $sellerOrderDetails1->sale_price = 100;
            $sellerOrderDetails1->quantity = 1;
            $sellerOrderDetails1->save();

            $sellerOrderDetails1 = new SellerOrderDetails();
            $sellerOrderDetails1->seller_order_id = $sellerOrder2->id;
            $sellerOrderDetails1->product_id = 3;
            $sellerOrderDetails1->sale_price = 100;
            $sellerOrderDetails1->quantity = 3;
            $sellerOrderDetails1->save();
    }
}
