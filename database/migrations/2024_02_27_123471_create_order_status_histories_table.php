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
        Schema::create('order_status_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('operator_id');
            $table->enum('previous_status', array_keys(Enum::getOrderStatusType()))->default(Enum::ORDER_STATUS_TYPE_PENDING)->comment('Pending, Canceled, Processing, Shipped, Delivered, Not Received, Returned, Incomplete');
            $table->enum('current_status', array_keys(Enum::getOrderStatusType()))->default(Enum::ORDER_STATUS_TYPE_PENDING)->comment('Pending, Canceled, Processing, Shipped, Delivered, Not Received, Returned, Incomplete');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
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
        Schema::dropIfExists('order_status_histories');
    }
};
