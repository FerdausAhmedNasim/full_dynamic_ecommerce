<?php

use App\Library\Enum;
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
        Schema::create('common_languages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('local', array_keys(Enum::getLanguageType()))->default(Enum::LANGUAGE_TYPE_ENGLISH);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->unsignedBigInteger('languageable_id');
            $table->string('languageable_type');
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
        Schema::dropIfExists('common_languages');
    }
};
