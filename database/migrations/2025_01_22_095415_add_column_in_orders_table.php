<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable()->change();
            $table->unsignedBigInteger('operator_id')->nullable()->change();

            $table->string('order_person_name')->after('address_id');
            $table->string('order_person_phone')->after('order_person_name');
            $table->string('order_person_address')->after('order_person_phone');
            $table->string('shipping_area')->after('order_person_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable(false)->change();
            $table->unsignedBigInteger('operator_id')->nullable(false)->change();

            $table->string('order_person_name');
            $table->string('order_person_phone');
            $table->string('order_person_address');
            $table->string('shipping_area');
        });
    }
};
