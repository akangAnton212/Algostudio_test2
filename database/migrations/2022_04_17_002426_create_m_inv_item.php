<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMInvItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_inv_item', function (Blueprint $table) {
            $table->id();
            $table->string('item_name', 30);
            $table->string('uid_item_group', 36)->nullable();
            $table->string('uid_item_type', 36)->nullable();
            $table->string('uid_store', 36)->nullable();
            $table->double('last_price')->nullable();
            $table->integer('stock')->default(0);
            $table->string('item_description')->nullable();
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
        Schema::dropIfExists('m_inv_item');
    }
}
