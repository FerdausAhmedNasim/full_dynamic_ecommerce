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
        Schema::create('product_services', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('order')->default(0);
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('operator_id');
            $table->timestamps();
            // icon store in attachment

            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('product_services');
    }
};
