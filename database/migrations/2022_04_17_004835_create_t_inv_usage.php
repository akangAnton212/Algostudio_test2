<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTInvUsage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_inv_usage', function (Blueprint $table) {
            $table->id();
            $table->string('uid_created_by', 36);
            $table->datetime('created_date');
            $table->string('uid_acc_by', 36)->nullable();
            $table->datetime('acc_date')->nullable();
            $table->string('usage_num', 15);
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
        Schema::dropIfExists('t_inv_usage');
    }
}
