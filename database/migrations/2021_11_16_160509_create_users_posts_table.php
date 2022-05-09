<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_post_id')->constrained('users')->cascadeOnDelete();
            $table->string('post_title');
            $table->string('post_info') ;
            $table->string('post_img')->nullable();
            $table->date('create_post');
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
        Schema::dropIfExists('users_posts');
    }
}
