<?php

namespace App\Services;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\Student;

class DataService 
{
    public function findGroupsInDB($number)
    {
        $data = Student::join('groups', 'students.group_id', '=', 'groups.id')
        ->select(\DB::raw('COUNT(*) as count'), 'groups.name')
        ->groupBy('groups.name')
        ->get()
        ->where('count', '<=', $number);

        return $data;
    }

    public function findStudentOnCourse($course)
    {
        $students = CourseStudent::join('courses', 'courses.id', '=', 'course_students.course_id')
        ->join('students', 'students.id', '=', 'course_students.student_id')
        ->select('students.first_name', 'students.last_name', 'courses.name', 'students.id')
        ->where('courses.name', '=', $course)
        ->get();

        return $students;
    }

    public function createNewStudent($data)
    {
        Student::create($data);
    }

    public function deleteStudent($student_id)
    {
        Student::where('students.id', '=', $student_id)
        ->delete();
    }

    public function getStudents()
    {
       return Student::get();
    }

    public function getCoursesStudentId()
    {
        return CourseStudent::join('courses', 'courses.id', '=', 'course_students.course_id')
        ->select('courses.name', 'course_students.student_id', 'courses.id')
        ->get();
    }

    public function getCoursesStudentsList()
    {
        return CourseStudent::join('courses', 'courses.id', '=', 'course_students.course_id')->join('students', 'students.id', '=', 'course_students.student_id')->select('students.first_name', 'students.last_name', 'courses.name')->get();
    }

    public function getCourses()
    {
        return Course::get();
    }

    public function addStudentToCourse($course, $student_id)
    {
        CourseStudent::insert([
            "student_id" => $student_id,
            "course_id" => Course::select('courses.id')->where('courses.name', $course)->first()->id,
       ]);
    }

    public function deleteStudentFromCourse($course, $student_id)
    {
        $data = Course::select('courses.id')->where('courses.name', '=', $course )->first()->id;

        CourseStudent::where('course_students.student_id', '=', $student_id)
         ->where('course_students.course_id', '=', $data)
         ->delete();
    }


}