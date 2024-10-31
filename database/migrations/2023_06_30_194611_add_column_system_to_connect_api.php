<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSystemToConnectApi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('connect_api', function (Blueprint $table) {
            $table->integer('system')->after('active')->default(1)->comment('1: cùng hệ thống|2: muabm365.com');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('connect_api', function (Blueprint $table) {
            $table->dropColumn('system');
        });
    }
}