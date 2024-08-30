<?php

namespace Tests\Feature;

use App\Models\CourseStudent;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class FormsTest extends TestCase
{
    use RefreshDatabase;
    public function test_forms_page_contains_forms(): void
    {
        $response = $this->get('/forms');

        $response->assertStatus(200)
        ->assertViewIs('forms')
        ->assertSee('Find groups with less or equals student count')
        ->assertSee('Add new student')
        ->assertSee('Find students related to the course')
        ->assertSee('Delete student by STUDENT_ID')
        ->assertSee('Show all students and their courses');
    }

    public function test_groups_page_returns_list_of_groups()
    {
        $response = $this->get('/forms/groups?number=25');

        $response->assertStatus(200)
        ->assertViewIs('groups')
        ->assertSeeText('Groups with 25 students or less');
    }

    public function test_courses_page_returns_list_of_students_related_on_course()
    {
        $response = $this->get('/forms/students/on/course?search=English');

        $students = CourseStudent::join('courses', 'courses.id', '=', 'course_students.course_id')
        ->join('students', 'students.id', '=', 'course_students.student_id')
        ->select('students.first_name', 'students.last_name', 'courses.name', 'students.id')
        ->where('courses.name', '=', 'English')
        ->get()->toArray();

        $response->assertStatus(200)
        ->assertViewIs('StudentsOnCourse')
        ->assertSee('List of students related to the English course')
        ->assertSeeTextInOrder($students);

    }
    public function test_page_returns_students_and_courses()
    {
        $response = $this->get('/forms/students/all/courses');

        $response->assertStatus(200)
        ->assertViewIs('StudentsAllCourses')
        ->assertSee('Students and courses they are related on');
    }

    public function test_create_student_successfull()
    {
        $student = [
            'first_name' => 'Alisa',
            'last_name' => 'Doggy'
        ];
        $response = $this->post('/forms/add', $student);

        $response->assertStatus(200)
        ->assertSee('Student Alisa Doggy was successfully added');

        $this->assertDatabaseHas('students', $student);
    }

    public function test_student_delete_successefully()
    {
        $student = Student::make([
            'first_name' => 'Anna',
            'last_name' => 'Dark',
        ]);

        $response = $this->delete('/forms/delete/?student_id='. $student->id);

        $response->assertStatus(200)
        ->assertSee('Student with student_id ' . $student->id . ' was successfully deleted');
    }
}
