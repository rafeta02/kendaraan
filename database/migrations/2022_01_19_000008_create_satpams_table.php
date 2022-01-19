<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSatpamsTable extends Migration
{
    public function up()
    {
        Schema::create('satpams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nip');
            $table->string('nama');
            $table->string('no_wa')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
