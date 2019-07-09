<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePilihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pilihan', function (Blueprint $table) {
            $table->bigincrements('id');
            $table->string('nama',200);
            $table->string('slug',200);
            $table->integer('form_id')->unsigned();
            $table->foreign('form_id')->references('id')->on('form')->onDelete('cascade');
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
        Schema::dropIfExists('pilihan');
    }
}
