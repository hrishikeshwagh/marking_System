<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('marks', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('student_id');
        $table->unsignedBigInteger('assignment_id');
        $table->unsignedBigInteger('component_id');
        $table->integer('marks_obtained');
        $table->timestamps();

        $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        $table->foreign('assignment_id')->references('id')->on('assignments')->onDelete('cascade');
        $table->foreign('component_id')->references('id')->on('components')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marks');
    }
}
