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
        Schema::create('advertises', function (Blueprint $table) {
            $table->id();
            $table->string('link')->nullable();
            $table->json('product_ids')->nullable();
            $table->enum('status', array_keys(Enum::getAdStatusType()))->default(Enum::AD_STATUS_ACTIVE);
            $table->enum('payment_status', array_keys(Enum::getAdPaymentStatusType()))->default(Enum::AD_PAYMENT_STATUS_UNPAID);
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('advertise_location_id');
            $table->float('amount')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
            // images store in attachment

            $table->foreign('advertise_location_id')->references('id')->on('advertise_locations');
            $table->foreign('seller_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertises');
    }
};
