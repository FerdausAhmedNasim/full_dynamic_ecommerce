<?php

use App\Library\Enum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();
            $table->string('invoice_id')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('operator_id');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->text('note')->nullable();
            $table->integer('quantity');
            $table->float('sub_total_amount', 15, 2)->default(0);
            $table->float('total_amount', 15, 2)->default(0);
            $table->float('discount_amount', 15, 2)->default(0);
            $table->float('ezzico_discount', 15, 2)->default(0);
            $table->float('return_amount', 15, 2)->default(0);
            $table->float('shipping_cost', 15, 2)->default(0);
            $table->float('penalty_amount', 15, 2)->default(0);
            $table->float('collected_amount', 15, 2)->default(0);
            $table->float('amount_to_be_collect', 15, 2)->default(0);
            $table->enum('order_status', array_keys(Enum::getOrderStatusType()))->default(Enum::ORDER_STATUS_TYPE_PENDING)->comment('Pending, Canceled, Processing, Shipped, Delivered, Not Received, Returned, Incomplete');
            $table->enum('payment_status', array_keys(Enum::getPaymentStatusType()))->default(Enum::ORDER_PAYMENT_STATUS_UNPAID)->comment('Unpaid, Partial, Paid, Refunded');
            $table->enum('payment_type', array_keys(Enum::getOrderPaymentType()))->default(Enum::ORDER_PAYMENT_TYPE_COD)->comment('cod, digital');
            $table->text('payment_details')->nullable();
            $table->timestamps();

            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('operator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
