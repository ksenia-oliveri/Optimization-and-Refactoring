<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class FormsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_returns_list_of_groups()
    {
        $response = $this->getJson('/api/v1/groups/?number=25');

        $response->assertStatus(200);
    }

    public function test_api_returns_list_of_students_on_course()
    {   
        $response = $this->json('GET', '/api/v1/students', ['course' => 'Math']);


        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has(25)
    ); // Root level does not have the expected size.
   // Failed asserting that actual size 0 matches expected size 25.
   // Там вообще он пустой почему-то
    }

    public function test_create_student_successfully()
    {   
        $student = ['first_name' => 'Anna', 
        'last_name' => 'Dark'];
        $response = $this->postJson('/api/v1/add', $student);

        $response->assertStatus(200);
        $response->assertJson($student);
    }

    public function test_api_returns_list_of_students_courses()
    {
        $response = $this->get('/api/v1/students/all/courses');

        $response->assertStatus(200);
    }
}
