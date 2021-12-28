<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStepbystepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('step_by_steps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('exercise_id')->unsigned();
            $table->string('order');
            $table->string('descStep');
            $table->string('imgStep')->nullable(true);
            $table->foreign('exercise_id')
            ->references('id')
            ->on('exercises')
            ->onDelete('cascade');
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
        Schema::dropIfExists('step_by_steps');
    }
}
