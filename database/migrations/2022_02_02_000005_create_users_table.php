<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->datetime('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('id_simpeg')->nullable();
            $table->string('nip')->nullable();
            $table->string('no_identitas')->nullable();
            $table->string('nama')->nullable();
            $table->string('username')->nullable();
            $table->longText('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('jwt_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
