<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnForConnectApiHistoryBuy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_buy', function (Blueprint $table) {
            $table->boolean('is_api')->after('type')->default(false);
            $table->integer('connect_api_id')->after('is_api')->nullable();
            $table->integer('price_api')->after('connect_api_id')->default(0);
            $table->integer('price_actual')->after('price_api')->default(0);
            $table->integer('profit')->after('price_actual')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_buy', function (Blueprint $table) {
            $table->dropColumn('is_api');
            $table->dropColumn('connect_api_id');
            $table->dropColumn('price_api');
            $table->dropColumn('price_actual');
            $table->dropColumn('profit');
        });
    }
}