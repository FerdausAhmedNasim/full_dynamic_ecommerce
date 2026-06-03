<?php

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

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 255)->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('order')->default(99);
            $table->boolean('active')->default(true);
            $table->boolean('featured')->default(false);
            $table->unsignedBigInteger('operator_id');
            // image will store attachment table

            $table->foreign('parent_id')->references('id')->on('categories');
            $table->foreign('operator_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
