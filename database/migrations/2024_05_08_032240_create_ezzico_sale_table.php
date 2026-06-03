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
        Schema::create('ezzico_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product_id");
            $table->date("start_date");
            $table->date("end_date");
            $table->unsignedBigInteger("operator_id");
            $table->timestamps();

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
        Schema::dropIfExists('ezzico_sales');
    }
};
