<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverKendaraanPivotTable extends Migration
{
    public function up()
    {
        Schema::create('driver_kendaraan', function (Blueprint $table) {
            $table->unsignedBigInteger('kendaraan_id');
            $table->foreign('kendaraan_id', 'kendaraan_id_fk_5916009')->references('id')->on('kendaraans')->onDelete('cascade');
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id', 'driver_id_fk_5916009')->references('id')->on('drivers')->onDelete('cascade');
        });
    }
}
