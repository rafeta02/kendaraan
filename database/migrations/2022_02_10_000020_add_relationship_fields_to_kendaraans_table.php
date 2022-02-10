<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToKendaraansTable extends Migration
{
    public function up()
    {
        Schema::table('kendaraans', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_kerja_id')->nullable();
            $table->foreign('unit_kerja_id', 'unit_kerja_fk_5916010')->references('id')->on('sub_units');
            $table->unsignedBigInteger('owned_by_id')->nullable();
            $table->foreign('owned_by_id', 'owned_by_fk_5963714')->references('id')->on('users');
        });
    }
}
