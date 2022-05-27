<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',100);
            $table->string('last_name',100);
            $table->string('patronymic',100);
            $table->string('email')->unique();
            $table->boolean('verification')->nullable();
            $table->string('verificationkey')->nullable();
            $table->string('avatar')->nullable();
            $table->string('about_img')->nullable();
            $table->string('about_title')->nullable();
            $table->text('about_information')->nullable();
            $table->string('role')->nullable() ;
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
        Schema::dropIfExists('users');
    }
}
