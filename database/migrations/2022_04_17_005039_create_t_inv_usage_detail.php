<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTInvUsageDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_inv_usage_detail', function (Blueprint $table) {
            $table->id();
            $table->string('uid_usage', 36);
            $table->string('uid_item', 36);
            $table->integer('qty');
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
        Schema::dropIfExists('t_inv_usage_detail');
    }
}
