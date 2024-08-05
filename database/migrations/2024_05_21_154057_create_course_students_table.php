<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_students', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('student_id');

            //IDX
            $table->index('course_id', 'course_student_course_idx');
            $table->index('student_id', 'course_student_student_idx');


            //FK
            $table->foreign('course_id', 'course_student_course_fk')->on('courses')->references('id');
            $table->foreign('student_id', 'course_student_student_fk')->on('students')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_students');
    }
};
