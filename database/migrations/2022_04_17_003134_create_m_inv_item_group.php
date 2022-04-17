<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMInvItemGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_inv_item_group', function (Blueprint $table) {
            $table->id();
            $table->string('group_name', 30);
            $table->string('alias_code', 10)->nullable();
            $table->string('alias_name', 25)->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('m_inv_item_group');
    }
}
