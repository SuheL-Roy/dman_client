<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickUpRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pick_up_requests', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_id')->nullable();
            $table->string('pickup_address')->nullable();
            $table->string('note')->nullable();
            $table->string('estimate_parcel')->nullable();
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
        Schema::dropIfExists('pick_up_requests');
    }
}
