<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnForApiConnectToTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('types', function (Blueprint $table) {
            $table->boolean('is_api')->after('icon')->default(false);
            $table->integer('connect_api_id')->after('is_api')->nullable();
            $table->integer('origin_api_id')->after('connect_api_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('types', function (Blueprint $table) {
            $table->dropColumn('is_api');
            $table->dropColumn('connect_api_id');
            $table->dropColumn('origin_api_id');
        });
    }
}