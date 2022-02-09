<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDairiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dairies', function (Blueprint $table) {
            $table->id();
            $table->date("date");
            $table->string("score")->nullable();
            $table->integer("album_id")->unsigned()->nullable();
            $table->text("experience")->nullable();
            $table->text("description")->nullable();
            $table->timestamps();
            $table->foreign("album_id")
                ->references("id")
                ->on("albums")
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dairies');
    }
}
