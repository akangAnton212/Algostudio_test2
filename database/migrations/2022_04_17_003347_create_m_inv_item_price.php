<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMInvItemPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_inv_item_price', function (Blueprint $table) {
            $table->id();
            $table->double('open_price');
            $table->double('last_price')->nullable();
            $table->date('activate_date');
            $table->string('uid_item', 36);
            $table->string('uid', 36);
            $table->boolean('enabled')->default(true);
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
        Schema::dropIfExists('m_inv_item_price');
    }
}
