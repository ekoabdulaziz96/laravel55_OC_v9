<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('nama',50);
            $table->string('no_hp',20);
            $table->string('email',50)->unique();
            $table->string('password',150);
            $table->string('foto',200)->nullable()->default('-');
            $table->string('status',50);
            
            $table->integer('cabang_id')->unsigned();
            $table->foreign('cabang_id')->references('id')->on('cabang')->onDelete('cascade');
            
            $table->integer('wilayah')->nullable()->default(0);
            $table->boolean('active',8)->default(false);
            $table->string('activation_token',300)->nullable()->default(null);

            $table->rememberToken();
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
