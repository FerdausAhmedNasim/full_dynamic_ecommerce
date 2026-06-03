<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('black_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('seller_order_id');
            $table->double("shipping_cost", 15, 2)->default(0);
            $table->boolean('active')->default(true);
            $table->dateTime('penalty_payment_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            // $table->foreign('seller_order_id')->references('id')->on('seller_orders')->onDelete('restrict');
            // ALTER TABLE black_users
            // DROP FOREIGN KEY black_users_seller_order_id_foreign;
            // DROP INDEX black_users_seller_order_id_foreign ON black_users;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('black_users');
    }
};
