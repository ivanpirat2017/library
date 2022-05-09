<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWatchbooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watchbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('watch_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('watch_book_id')->constrained('books')->cascadeOnDelete();
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
        Schema::dropIfExists('watchbooks');
    }
}
