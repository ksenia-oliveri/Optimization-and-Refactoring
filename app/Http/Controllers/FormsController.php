<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use App\Services\DataService;

class FormsController extends Controller
{   
    private DataService $dataService;

    public function __construct(DataService $service)
    {
        $this->dataService = $service;
    }
    // main page with forms
    public function index()
    {   
        return view("forms");
    }

    //get list of groups with same or less nimber of students
    public function showGroups(Request $request)
    {
        $number = $request->number;
        $groups = $this->dataService->findGroupsInDB($number);
        return view('groups', compact(['groups', 'number']));
    }

    // get list of students related to the course
    public function findStudentsOnCourse(Request $request)
    {
        $course = $request->course;
        $students = $this->dataService->findStudentOnCourse($course);

        return view("StudentsOnCourse", compact(['students', 'course']));
    }
    // create a new student
    public function addNewStudent(StoreRequest $request): string
    {
        $data = $request->validated();
       $this->dataService->createNewStudent($data);

       return 'Student ' . $data['first_name'] . ' '. $data['last_name'] . ' was successfully added';
    }
    
    //delete student by student_id
    public function deleteStudent(Request $request): string
    {
        $student_id = $request->student_id;
        $this->dataService->deleteStudent($student_id);

        return 'Student with student_id ' . $student_id . ' was successfully deleted';
    }

    // return list with all students and their courses
    public function allStudentsCourses()
    {
        $students = $this->dataService->getStudents();
        $studentsCourses = $this->dataService->getCoursesStudentId();
        $courses = $this->dataService->getCourses();

        return view('StudentsAllCourses', compact(['students', 'studentsCourses', 'courses']));
    }

    //add course to student
    public function addStudentToCourse(Request $request, $student_id)
    {   
        $course = $request->course;
        $this->dataService->addStudentToCourse($course, $student_id);

        return redirect()->route('get.all.students.courses');
    }

    //delete course from student
    public function deleteStudentFromCourse(Request $request, $student_id)
    {   
        $course = $request->course;
        $this->dataService->deleteStudentFromCourse($course, $student_id);

        return redirect()->route('get.all.students.courses');
    }
}
