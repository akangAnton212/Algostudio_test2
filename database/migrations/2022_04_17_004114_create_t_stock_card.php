<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTStockCard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_inv_stock_card', function (Blueprint $table) {
            $table->id();
            $table->smallinteger('trans_type');
            $table->datetime('trans_date');
            $table->string('uid_item', 36);
            $table->double('initial_balance');
            $table->double('qty');
            $table->double('final_balance');
            $table->string('information');
            $table->string('ref_number', 50)->nullable();
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
        Schema::dropIfExists('t_inv_stock_card');
    }
}
