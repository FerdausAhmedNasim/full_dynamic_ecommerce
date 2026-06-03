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
        Schema::create('order_returns', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->unique();
            $table->unsignedBigInteger('seller_order_id');
            $table->unsignedBigInteger('operator_id');
            $table->string('payment_method')->nullable();
            // $table->float('shipping_cost')->default(0);
            $table->float('sub_total_amount', 15, 2)->default(0);
            $table->float('coupon_discount', 15, 2)->default(0);
            $table->float('total_amount', 15, 2)->default(0);
            $table->string('payment_transaction_id')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', array_keys(Enum::getReturnStatusType()))->default(Enum::RETURN_STATUS_PENDING)->comment('Pending, Approved, Rejected, Processed');
            $table->timestamps();

            $table->foreign('seller_order_id')->references('id')->on('seller_orders');
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
        Schema::dropIfExists('order_returns');
    }
};
//
