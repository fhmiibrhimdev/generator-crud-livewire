<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    public function up()
    {
        Schema::create('blog', function (Blueprint $table) {
            $table->id();
            $table->text('tanggal');
            $table->text('judul');
            $table->text('deskripsi');
            $table->text('status_publish');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('blog');
    }
}