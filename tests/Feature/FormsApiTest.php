<?php

namespace Tests\Feature;

use App\Models\CourseStudent;
use App\Models\Student;
use App\Services\DataService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormsApiTest extends TestCase
{
    use RefreshDatabase;
    public function test_api_returns_list_of_groups()
    {
        $response = $this->getJson('/api/v1/groups?number=25');
        $data = (new DataService)->findGroupsInDB(25)->toArray();
        $response->assertStatus(200)
        ->assertJson($data)
        ->assertJsonStructure($data);
    }

    public function test_api_returns_list_of_students_on_course()
    {   
        $response = $this->getJson('api/v1/students/on/course?course=Math');
        $data = (new DataService)->findStudentOnCourse('Math')->toArray();
        $response->assertStatus(200);
        $response->assertJson( $data);
    }

    public function test_create_student_successfully()
    {   
        $student = ['first_name' => 'Anna', 
        'last_name' => 'Dark'];
        $response = $this->postJson('/api/v1/add', $student);

        $response->assertStatus(201);
        $response->assertJson($student);
    }

    public function test_delete_student_successefully()
    {
        $student = Student::create([
            'first_name' => 'Anna',
            'last_name' => 'Dark',
        ])->toArray();

        $response = $this->deleteJson('/api/v1/delete?student_id=' . $student['id']);

        $response->assertStatus(200)
        ->assertJson(['message' => 'student was successefully deleted']);    
    }

    public function test_api_returns_list_of_students_courses()
    {
        $response = $this->get('/api/v1/students/all/courses');

        $data = (new DataService)->getCoursesStudentsList()->toArray();
        $response->assertStatus(200)
        ->assertJson($data);
    }

}
