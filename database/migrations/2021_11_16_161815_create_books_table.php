<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->text('description')->nullable();
            $table->foreignId('genre_book_id')->nullable()->constrained('genres')->cascadeOnDelete();
            $table->foreignId('book_status_id')->nullable()->constrained('book_status')->cascadeOnDelete();
            $table->string('bookimg')->nullable();
            $table->string('bookurl')->nullable();
            $table->double('reting')->nullable()->default(0.000);
            $table->string('release')->nullable();
            $table->integer('price_book')->nullable()->default(0);
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
        Schema::dropIfExists('books');
    }
}
