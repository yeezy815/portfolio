<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_experiences', function (Blueprint $table) {
            $table->id();
            $table->date("date");
            $table->string("score")->nullable();
            $table->integer("album_id")->unsigned()->nullable();
            $table->text("experience")->nullable();
            $table->text("description")->nullable();
            $table->timestamps();
            $table->foreign("album_id")->references("id")->on("albums");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('album_experiences');
    }
}
