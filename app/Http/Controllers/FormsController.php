<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use App\Services\DataService;

class FormsController extends Controller
{
    public function index()
    {   
        return view("forms");
    }

    public function findGroups(Request $request)
    {
        $number = $request->number;
        $groups = (new DataService)->findGroupsInDB($number);

        return view('groups', compact(['groups', 'number']));
    }

    public function findStudentsOnCourse(Request $request)
    {
        $search = $request->search;
        $students = (new DataService)->findStudentOnCourse($search);

        return view("StudentsOnCourse", compact(['students', 'search']));
    }

    public function addNewStudent(StoreRequest $request)
    {
        $data = $request->validated();
       (new DataService)->createNewStudent($data);

       return 'Student ' . $data['first_name'] . ' '. $data['last_name'] . ' was successfully added';
    }

    public function deleteStudent(Request $request)
    {
        $student_id = $request->student_id;
        (new DataService)->deleteStudent($student_id);

        return 'Student with student_id ' . $student_id . ' was successfully deleted';
    }

    public function allStudentsCourses()
    {
        $students = (new DataService)->getStudents();
        $studentsCourses = (new DataService)->getCoursesStudentId();
        $courses = (new DataService)->getCourses();

        return view('StudentsAllCourses', compact(['students', 'studentsCourses', 'courses']));
    }

    public function addStudentToCourse(Request $request, $student_id)
    {   
        $course = $request->course;
        (new DataService)->addStudentToCourse($course, $student_id);

        return redirect()->route('get.all.students.courses');
    }

    public function deleteStudentFromCourse(Request $request, $student_id)
    {   
        $course = $request->course;
        (new DataService)->deleteStudentFromCourse($course, $student_id);

        return redirect()->route('get.all.students.courses');
    }
}
