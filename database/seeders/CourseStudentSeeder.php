<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(Student::get() as $student) {
            \DB::table("course_students")->insert([
                "student_id" => $student->id,
                "course_id" => Course::get()->random()->id,
            ]);
        }

        foreach(Student::get()->random(100) as $student) {
            \DB::table("course_students")->insert([
                "student_id" => $student->id,
                "course_id" => Course::get()->random()->id,
            ]);
        }

        foreach(Student::get()->random(75) as $student) {
            \DB::table("course_students")->insert([
                "student_id" => $student->id,
                "course_id" => Course::get()->random()->id,
            ]);
        }
    }
}
