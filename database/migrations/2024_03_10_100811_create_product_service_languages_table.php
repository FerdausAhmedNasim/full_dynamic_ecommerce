<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_service_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_service_id');
            $table->string('local');
            $table->string('title');
            $table->string('sub_title');
            $table->timestamps();

            $table->foreign('product_service_id')->references('id')->on('product_services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_service_languages');
    }
};
