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
        Schema::create('campaign_request_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_request_id');
            $table->unsignedBigInteger('product_id');
            $table->enum('discount_type', [1,2,3]);
            $table->integer('discount')->default(0);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('campaign_request_id')->references('id')->on('campaign_requests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_request_products');
    }
};
