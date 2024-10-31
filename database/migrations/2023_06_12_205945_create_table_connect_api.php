<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableConnectApi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connect_api', function (Blueprint $table) {
            $table->id();
            $table->string('domain');
            $table->string('api_key');
            $table->integer('auto_price')->default(10);
            $table->boolean('auto_change_name')->default(false);
            $table->boolean('active')->default(true);
            $table->integer('balance')->default(0);
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
        Schema::dropIfExists('connect_api');
    }
}