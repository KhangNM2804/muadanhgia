<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColFlagAutoMomoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('momo', function (Blueprint $table) {
            $table->integer('flag_auto')->nullable()->default(0)->after('data_account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('momo', function (Blueprint $table) {
            $table->dropColumn(['flag_auto']);
        });
    }
}
