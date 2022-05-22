<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_token_id')->constrained('users')->cascadeOnDelete();
            $table->string('api_token')->nullable();
            $table->string('ip')->nullable();
            $table->string('type')->nullable();
            $table->string('continent')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('postal')->nullable();
            $table->string('browser')->nullable();
            $table->string('flagimg')->nullable();
            $table->boolean('del')->nullable();
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
        Schema::dropIfExists('tokens');
    }
}
