<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnForConnectApiToCategoryTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categorys', function (Blueprint $table) {
            $table->boolean('is_api')->after('sort_num')->default(false);
            $table->integer('connect_api_id')->after('is_api')->nullable();
            $table->integer('origin_api_id')->after('connect_api_id')->nullable();
            $table->integer('origin_price')->after('origin_api_id')->default(0);
            $table->integer('quantity_remain')->after('origin_price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categorys', function (Blueprint $table) {
            $table->dropColumn('is_api');
            $table->dropColumn('connect_api_id');
            $table->dropColumn('origin_api_id');
            $table->dropColumn('origin_price');
            $table->dropColumn('quantity_remain');
        });
    }
}