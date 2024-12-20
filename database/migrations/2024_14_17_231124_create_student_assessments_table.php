<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                ->constrained('students')
                ->onDelete('cascade');
            $table->foreignId('classroom_id')
                ->constrained('classrooms')
                ->onDelete('cascade');
            $table->enum('quarter', ['1st', '2nd', '3rd', '4th']);
            $table->enum('assessment_type', ['ww', 'pt', 'qa']);
            $table->string('score');
            $table->string('max_score');
            $table->string('date');

            $table->string('image')->nullable();
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
        Schema::dropIfExists('student_assessments');
    }
}
