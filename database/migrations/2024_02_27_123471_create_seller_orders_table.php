<?php

use App\Library\Enum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('seller_id')->default(2);
            $table->unsignedBigInteger('operator_id');
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->integer('quantity');
            $table->string('order_from')->default('website');
            $table->date('payment_date')->nullable();
            $table->float('commission_amount', 15, 2)->default(0);
            $table->float('sub_total_amount', 15, 2)->default(0);
            $table->float('total_amount', 15, 2)->default(0);
            $table->float('discount_amount', 15, 2)->default(0);
            $table->float('ezzico_discount', 15, 2)->default(0);
            $table->float('return_amount', 15, 2)->default(0);
            $table->float('shipping_cost')->default(0);
            $table->enum('order_status', array_keys(Enum::getOrderStatusType()))->default(Enum::ORDER_STATUS_TYPE_PENDING)->comment('Pending, Canceled, Processing, Shipped, Delivered, Not Received, Returned, Incomplete');
            $table->enum('payment_status', array_keys(Enum::getPaymentStatusType()))->default(Enum::ORDER_PAYMENT_STATUS_UNPAID)->comment('Unpaid, Paid, Refunded');
            $table->enum('payment_type', array_keys(Enum::getOrderPaymentType()))->default(Enum::ORDER_PAYMENT_TYPE_COD)->comment('cod, digital');

            $table->foreign('seller_id')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('operator_id')->references('id')->on('users');
            $table->foreign('coupon_id')->references('id')->on('coupons');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_orders');
    }
};
