<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMomoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('momo', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('rkey',500)->nullable();
            $table->string('imei',500)->nullable();
            $table->string('onesignal',500)->nullable();
            $table->string('ohash',500)->nullable();
            $table->string('setupkey',500)->nullable();
            $table->string('auth_token',2000)->nullable();
            $table->string('requestkey',200)->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->integer('balance')->nullable()->default(0);
            $table->longText('data_account')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('momo');
    }
}
