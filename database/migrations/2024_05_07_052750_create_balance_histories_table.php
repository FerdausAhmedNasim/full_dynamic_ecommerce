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
        Schema::create('balance_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id');
            $table->foreignId('settlement_id')->nullable();
            $table->foreignId('operator_id')->nullable();
            $table->enum('type', array_keys(Enum::getBalanceHistoryStatus()));
            $table->float('amount')->default(0);
            $table->string('dr_cr');
            $table->string('transaction_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('balance_histories');
    }
};
