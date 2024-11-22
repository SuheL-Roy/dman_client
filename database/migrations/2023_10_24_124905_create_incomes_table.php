<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_no', 200)->nullable();
            $table->string('date', 200)->nullable();
            $table->string('income_type', 200)->nullable();
            $table->string('income_for', 200)->nullable();
            $table->string('amount', 200)->nullable();
            $table->longText('details')->nullable();
            $table->string('status', 200)->nullable();
            $table->string('create_by', 200)->nullable();
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
        Schema::dropIfExists('incomes');
    }
}
