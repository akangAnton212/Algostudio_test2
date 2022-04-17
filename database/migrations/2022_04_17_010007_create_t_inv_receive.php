<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTInvReceive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_inv_receive', function (Blueprint $table) {
            $table->id();
            $table->string('uid_order', 36);
            $table->datetime('receive_date');
            $table->string('receive_num', 15)->nullable();
            $table->string('invoice_num', 25)->nullable();
            $table->string('delivery_note')->nullable();
            $table->string('uid_receive_by', 36);
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
        Schema::dropIfExists('t_inv_receive');
    }
}
