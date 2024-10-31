<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('buy_id')->nullable();
            $table->integer('priority')->default(2);
            $table->string('title', 200);
            $table->text('content');
            $table->integer('status')->default(1)->comment('1: ticket mới, 2: khách hàng trả lời, 3: Admin trả lời, 4: close, 5: reopen');
            $table->string('ip_address')->nullable();

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
        Schema::dropIfExists('tickets');
    }
}
