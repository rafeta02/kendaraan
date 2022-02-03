<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToLogPeminjamenTable extends Migration
{
    public function up()
    {
        Schema::table('log_peminjamen', function (Blueprint $table) {
            $table->unsignedBigInteger('peminjaman_id')->nullable();
            $table->foreign('peminjaman_id', 'peminjaman_fk_5819110')->references('id')->on('pinjams');
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->foreign('kendaraan_id', 'kendaraan_fk_5815600')->references('id')->on('kendaraans');
            $table->unsignedBigInteger('peminjam_id')->nullable();
            $table->foreign('peminjam_id', 'peminjam_fk_5815601')->references('id')->on('users');
        });
    }
}
