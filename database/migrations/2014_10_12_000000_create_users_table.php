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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('google_id')->nullable();
            $table->enum('user_type', array_keys(Enum::getUserType()));
            $table->string('gender')->nullable()->comment('Comes from config');
            $table->string('dob')->nullable();
            $table->enum('customer_type', array_keys(Enum::getCustomerTypes()))->default(Enum::CUSTOMER_TYPE_INDIVIDUAL)->comment('Individual, Business');
            $table->enum('status', array_keys(Enum::getUserStatus()))->default(Enum::USER_STATUS_PENDING)->comment('1 = PENDING, 2 = ACTIVE, 3 = SUSPENDED');
            $table->string('avatar', 255)->nullable();
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->dateTime('email_verified_at')->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->float('balance', 15, 2)->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('users');
    }
};
