<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompilationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compilations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compilationthemes_id')->constrained('compilation_themes')->cascadeOnDelete();
            $table->string('title');
            $table->text('body');
            $table->string('compilation_img');
            $table->date('compilation_start');
            $table->date('compilation_end');
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
        Schema::dropIfExists('compilations');
    }
}
