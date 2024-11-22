<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoverageAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coverage_areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('inside')->nullable();
            $table->string('district')->nullable();
            $table->string('area')->nullable();
            $table->integer('post_code')->nullable();
            $table->tinyInteger('h_delivery')->nullable();
            $table->integer('oneRe')->nullable();
            $table->integer('oneUr')->nullable();
            $table->integer('plusRe')->nullable();
            $table->integer('plusUr')->nullable();
            $table->integer('cod')->nullable();
            $table->integer('insurance')->nullable();
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
        Schema::dropIfExists('coverage_areas');
    }
}
