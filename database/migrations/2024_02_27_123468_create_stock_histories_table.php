<?php

use App\Library\Enum;
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

        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id');
            $table->integer('quantity')->default(0);
            //$table->enum('type', [])->comment('Addition, Subtraction');
            $table->enum('status', array_keys(Enum::getStockStatus()))->comment('WARRANTY, DAMAGED, MISSION, PURCHASE RETURNED, SALE RETURN, TRANSFER, EXPIRED');
            $table->unsignedBigInteger('operator_id');
            $table->text('note')->nullable();

            $table->foreign('stock_id')->references('id')->on('stocks');
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
        Schema::dropIfExists('stock_histories');
    }
};
