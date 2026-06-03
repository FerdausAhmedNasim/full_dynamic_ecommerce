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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('facebook')->nullable();
            $table->string('google')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('slug')->unique();
            $table->string('license_no')->nullable();
            $table->integer('rating_count')->default(0);
            $table->integer('reviews_count')->default(0);
            $table->boolean('active')->default(false);
            $table->unsignedBigInteger('seller_id');
            $table->timestamps();
            $table->softDeletes();
            // logo banner, tax_paper store in attachment

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
        Schema::dropIfExists('stores');
    }
};
