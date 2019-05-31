<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->unsignedInteger('director_id')->nullable();
            $table->boolean('seen')->default(false);
            $table->string('rating')->nullable(); // "fantastic", "bad", null
            $table->string('possession_state')->nullable(); // "own" / "to_own" / null
            $table->string('image')->nullable();
            $table->string('actor')->nullable();
            $table->integer('duration')->nullable();
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
        Schema::dropIfExists('movies');
    }
}
