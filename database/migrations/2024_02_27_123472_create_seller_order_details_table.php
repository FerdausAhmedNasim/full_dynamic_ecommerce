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
        Schema::create('seller_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('stock_variant_id')->nullable();
            $table->integer('quantity');
            $table->integer('return_quantity')->nullable();
            $table->float('product_price', 15, 2)->default(0);
            $table->float('sale_price', 15, 2)->default(0);
            $table->enum('discount_type', array_keys(Enum::getDiscountType()))->nullable()->comment('percentage, flat');
            $table->float('discount', 15, 2)->default(0);
            $table->float('ezzico_discount', 15, 2)->default(0);
            $table->float('shipping_cost', 15, 2)->default(0);
            $table->timestamps();

            $table->foreign('seller_order_id')->references('id')->on('seller_orders');
            $table->foreign('product_id')->references('id')->on('products');

            // We can't use constraint here as it prevent to edit product
            // $table->foreign('stock_variant_id')->references('id')->on('product_stocks');
            // ALTER TABLE seller_order_details
            // DROP FOREIGN KEY seller_order_details_stock_variant_id_foreign;
            // DROP INDEX seller_order_details_stock_variant_id_foreign ON seller_order_details;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_order_details');
    }
};
