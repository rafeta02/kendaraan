<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKendaraansTable extends Migration
{
    public function up()
    {
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plat_no');
            $table->string('merk');
            $table->string('jenis');
            $table->string('kondisi');
            $table->string('operasional')->nullable();
            $table->boolean('is_used')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
