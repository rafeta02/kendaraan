<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPinjamsTable extends Migration
{
    public function up()
    {
        Schema::table('pinjams', function (Blueprint $table) {
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id', 'kendaraan_fk_5819094')->references('id')->on('kendaraans');
            $table->unsignedBigInteger('borrowed_by_id')->nullable();
            $table->foreign('borrowed_by_id', 'borrowed_by_fk_5819102')->references('id')->on('users');
            $table->unsignedBigInteger('processed_by_id')->nullable();
            $table->foreign('processed_by_id', 'processed_by_fk_5819103')->references('id')->on('users');
            $table->unsignedBigInteger('driver_id')->nullable();
            $table->foreign('driver_id', 'driver_fk_5824651')->references('id')->on('drivers');
            $table->unsignedBigInteger('satpam_id')->nullable();
            $table->foreign('satpam_id', 'satpam_fk_5860331')->references('id')->on('satpams');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_5819109')->references('id')->on('users');
        });
    }
}
