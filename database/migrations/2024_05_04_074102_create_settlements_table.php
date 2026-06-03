<?php

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
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->boolean('money_sent')->default(false);
            $table->foreignId('seller_id');
            $table->float('total_sale')->default(0);
            $table->float('commission')->default(0);
            $table->float('ad_cost')->default(0);
            $table->float('amount')->default(0);
            $table->date('date');
            $table->date('start_date')->comment('Settlement period start');
            $table->date('end_date')->comment('Settlement period end');
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
        Schema::dropIfExists('settlements');
    }
};
