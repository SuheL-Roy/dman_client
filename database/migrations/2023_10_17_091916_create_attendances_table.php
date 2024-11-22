<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('user_id',255)->nullable();
            $table->string('name',255)->nullable();
            $table->string('mobile',255)->nullable();
            $table->string('area',255)->nullable();
            $table->string('status',255)->nullable();
            $table->string('rider_name',255)->nullable();
            $table->string('in_time',255)->nullable();
            $table->string('out_time',255)->nullable();
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
        Schema::dropIfExists('attendances');
    }
}
