<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswasTable extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->text('nama_lengkap');
            $table->text('nim');
            $table->text('deskripsi');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
