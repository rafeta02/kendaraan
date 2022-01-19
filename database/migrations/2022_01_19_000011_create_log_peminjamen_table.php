<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogPeminjamenTable extends Migration
{
    public function up()
    {
        Schema::create('log_peminjamen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('jenis');
            $table->longText('log')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
