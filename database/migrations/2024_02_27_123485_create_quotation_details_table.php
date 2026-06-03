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
        Schema::create('quotation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->float('unit_price', 15, 2)->default(0);
            $table->integer('quantity')->default(0);
            $table->float('discount_amount', 15, 2)->default(0);
            $table->float('packaging_cost', 15, 2)->default(0);
            $table->float('delivery_cost', 15, 2)->default(0);
            $table->float('other_cost', 15, 2)->default(0);
            $table->float('total_amount', 15, 2)->default(0);

            $table->foreign('quotation_id')->references('id')->on('quotations');
            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('quotation_details');
    }
};
