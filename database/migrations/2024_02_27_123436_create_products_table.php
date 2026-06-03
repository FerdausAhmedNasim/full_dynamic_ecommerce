<?php

use App\Library\Enum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('slug')->unique();
            $table->enum('type', array_keys(Enum::getProductTypes()))->default(Enum::PRODUCT_TYPE_SIMPLE)->comment('Simple, Variant, combo');
            $table->string('unit')->nullable();
            $table->float('weight', 15, 2)->nullable();
            $table->string('barcode')->nullable();
            $table->boolean('has_variant')->nullable();
            $table->string('attribute_sets')->nullable();
            $table->mediumText('selected_variants')->nullable();
            $table->mediumText('selected_variants_ids')->nullable();
            $table->integer('current_stock')->default(0);
            $table->integer('minimum_order_quantity')->default(1);
            $table->integer('purchase_price')->default(0);
            $table->boolean('stock_notification')->default(false);
            $table->integer('low_stock_to_notify')->default(0);
            $table->enum('stock_visibility', array_keys(Enum::getProductVisibilityStatus()))->default(Enum::VISIBILITY_STATUS_HIDE_STOCK)->comment('hide_stock, visible_with_text, visible_with_quantity');
            $table->bigInteger('total_sale')->default(0);
            $table->enum('status', array_keys(Enum::getProductStatus()))->default(Enum::PRODUCT_STATUS_UNPUBLISHED)->comment('trash, published, unpublished');
            $table->boolean('approved')->default(true);
            $table->boolean('featured')->default(false);
            $table->boolean('refundable')->default(false);
            $table->float('rating', 15, 2)->default(0.00);
            $table->boolean('has_product_base_shipping')->default(false);
            $table->boolean('has_discount')->default(false);
            $table->unsignedBigInteger('seller_id')->default(2);
            $table->boolean('cash_on_delivery')->default(false)->comment('0 not available, 1 available');
            $table->float('unit_price', 15, 2)->default(0);
            $table->unsignedBigInteger('operator_id');

            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('operator_id')->references('id')->on('users');
            $table->foreign('seller_id')->references('id')->on('users');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
