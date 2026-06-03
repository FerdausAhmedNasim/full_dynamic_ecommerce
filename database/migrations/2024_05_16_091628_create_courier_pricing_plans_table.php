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
        Schema::create('courier_pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string("pickup_location");
            $table->string("delivery_location");
            $table->integer("min_weight");
            $table->integer("max_weight");
            $table->double("price", 15, 2)->default(0);
            $table->boolean('active')->default(true);
            $table->string("delivery_time")->nullable();
            $table->unsignedBigInteger("operator_id");
            $table->timestamps();

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
        Schema::dropIfExists('courier_pricing_plans');
    }
};