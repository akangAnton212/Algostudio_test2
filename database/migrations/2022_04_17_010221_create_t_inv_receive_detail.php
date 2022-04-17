<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTInvReceiveDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_inv_receive_detail', function (Blueprint $table) {
            $table->id();
            $table->string('uid_receive', 36);
            $table->string('uid_item', 36);
            $table->string('uid_order_detail', 36)->nullable();
            $table->integer('qty_order')->nullable();
            $table->integer('qty_receive');
            $table->boolean('enabled')->default(true);
            $table->string('uid', 36);
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
        Schema::dropIfExists('t_inv_receive_detail');
    }
}
