<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManajersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manajer', function (Blueprint $table) {
           $table->increments('id');
            $table->string('status_laporan',50)->default('baru');
            $table->string('kehadiran',50)->default('hadir');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('perpanjang_deadline')->nullable()->default(false);
            $table->timestamps();
            $table->timestamp('expired_at')->nullable()->default(null);
            
            $table->string('acc_direktur',20)->nullable()->default('baru');
            $table->string('komentar_direktur',999)->nullable()->default('-');
            $table->boolean('send_direktur')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manajer');
    }
}
