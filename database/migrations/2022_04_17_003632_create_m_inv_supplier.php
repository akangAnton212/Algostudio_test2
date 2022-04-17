<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMInvSupplier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_inv_supplier', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name', 100);
            $table->string('address', 200);
            $table->string('npwp_num', 50);
            $table->string('phone', 15);
            $table->string('email', 100)->nullable();
            $table->string('pic', 50);
            $table->string('pic_phone', 15);
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
        Schema::dropIfExists('m_inv_supplier');
    }
}
