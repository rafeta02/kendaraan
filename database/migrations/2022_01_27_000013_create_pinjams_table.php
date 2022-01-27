<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinjamsTable extends Migration
{
    public function up()
    {
        Schema::create('pinjams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_start');
            $table->date('date_end');
            $table->date('date_borrow')->nullable();
            $table->date('date_return')->nullable();
            $table->string('reason');
            $table->string('status');
            $table->longText('status_text')->nullable();
            $table->boolean('driver_status')->default(0)->nullable();
            $table->boolean('key_status')->default(0)->nullable();
            $table->boolean('is_done')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
