<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantAdvancePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_advance_payments', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable();
            $table->integer('merchant_id')->nullable();
            $table->string('business')->nullable();
            $table->string('area')->nullable();
            $table->string('phone')->nullable();
            $table->decimal('amount',20,2)->nullable();
            $table->text('comment')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('merchant_advance_payments');
    }
}
