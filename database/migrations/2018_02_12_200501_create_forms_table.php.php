<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('urutan');
            $table->string('nama',52);
            $table->string('slug',52);
            $table->string('tipe',30);
            $table->integer('set_row')->nullable()->default(null);
            $table->string('status',50);
            $table->string('kategori',30);
            $table->string('view',30);

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
        Schema::dropIfExists('form');
        //
    }
}
