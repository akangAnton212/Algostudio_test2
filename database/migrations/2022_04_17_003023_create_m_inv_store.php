<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMInvStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_inv_store', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('address', 150)->nullable();
            $table->string('phone', 15)->nullable();
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
        Schema::dropIfExists('m_inv_store');
    }
}
