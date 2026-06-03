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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum('type', array_keys(Enum::getPaymentType()))->comment('Sale, Purchase, Sale Return, Purchase Return');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('return_id')->nullable();
            $table->unsignedBigInteger('operator_id');
            $table->string('payment_method')->nullable();
            $table->float('amount', 15, 2)->default(0);
            $table->string('transaction_id')->nullable();
            $table->text('note')->nullable();
            $table->enum('payment_status', array_keys(Enum::getPaymentStatus()))->default(Enum::PAYMENT_STATUS_FAILED)->comment('Success, Failed');
            $table->timestamps();

            $table->foreign('return_id')->references('id')->on('order_returns');
            $table->foreign('operator_id')->references('id')->on('users');
            // $table->foreign('order_id')->references('id')->on('orders');
            // ALTER TABLE payments
            // DROP FOREIGN KEY payments_order_id_foreign;
            // DROP INDEX payments_order_id_foreign ON payments;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
