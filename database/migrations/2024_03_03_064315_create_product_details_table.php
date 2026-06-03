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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->enum('shipping_type', array_keys(Enum::getShippingType()))->nullable()->comment('flat rate, free shipping');
            $table->float('shipping_fee', 15, 2)->default(0.00);
            $table->boolean('shipping_fee_depend_on_quantity')->default(false);
            $table->boolean('shipping_fee_depend_on_weight')->default(false);
            $table->text('estimated_shipping_days')->nullable()->comment('estimated time of delivering the product');
            $table->bigInteger('viewed')->default(0)->comment('total views of the product');
            $table->float('discount', 15, 2)->nullable();
            $table->enum('discount_type', array_keys(Enum::getDiscountType()))->nullable()->comment('percentage, flat');
            $table->dateTime('discount_start')->nullable();
            $table->dateTime('discount_end')->nullable();
            $table->json('dimension')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_details');
    }
};
