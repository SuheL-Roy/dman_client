<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderConfirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_confirms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tracking_id')->nullable();
            $table->double('colection', 10, 2)->nullable();
            $table->double('delivery', 10, 2)->nullable();
            $table->double('insurance', 10, 2)->nullable();
            $table->double('cod', 10, 2)->nullable();
            $table->double('merchant_pay', 10, 2)->nullable();
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
        Schema::dropIfExists('order_confirms');
    }
}
