<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Http\Resources\GroupsResource;
use App\Http\Resources\StudentsAllCoursesResource;
use App\Http\Resources\StudentsResource;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\Student;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Students info",
 *      description="Information about students, groups and their courses",
 * )
 *
 */

class FormsApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/groups",
     *      operationId="getGroupsWithLessOrEqualStudents",
     *      tags={"Groups"},
     *      summary="Get list of groups with less or equals number of students",
     *      description="Returns list of groups",
     *      @OA\Parameter(
     *          name="number",
     *          description="Count of students",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:projects", "read:projects"}
     *         }
     *     },
     * )
     */

    public function findGroups(Request $request)
    {
        $number = $request->number;
        GroupsResource::collection(Student::join('groups', 'students.group_id', '=', 'groups.id')->select(\DB::raw('COUNT(*) as count'), 'groups.name')->groupBy('groups.name')->get()->where('count', '<=', $number));

        return response()->json();
    }

    /**
     * @OA\Get(
     *      path="/api/v1/students",
     *      operationId="GetStudentsRelatedToTheCourse",
     *      tags={"Students"},
     *      summary="Get list of students related to the course ",
     *      description="Returns list of students",
     *      @OA\Parameter(
     *          name="name",
     *          description="Course name",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:projects", "read:projects"}
     *         }
     *     },
     * )
     */

    public function findStudentsOnCourse(Request $request)
    {
        $course = $request->course;
        $data = StudentsResource::collection(CourseStudent::join('courses', 'courses.id', '=', 'course_students.course_id')->join('students', 'students.id', '=', 'course_students.student_id')->select('students.first_name', 'students.last_name', 'courses.name')->where('courses.name', '=', $course)->get());

        return response()->json($data);
    }

    /**
    * @OA\Post(
    *     path="/api/v1/add",
    *     tags={"Students"},
    *     summary="Adds a new student",
    *     @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="first_name",
    *                     type="string"
    *                 ),
    *                 @OA\Property(
    *                     property="last_name",
    *                     type="string"
    *                 ),
    *                 example={"first_name": "Anna", "last_name": "Smith"}
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="OK",
    *         @OA\JsonContent(
    *            @OA\Property(property="data", type="object",
    *                  @OA\Property(property="first_name", type="string"),
    *                  @OA\Property(property="last_name", type="string"),
    *
    *
    * )
    *         )
    *     )
    * )
    */
    public function addNewStudent(StoreRequest $request)
    {
        $student = StudentsResource::make(Student::create($request->validated()));

        return response()->json($student);
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/delete",
     *      tags={"Students"},
     *      summary="Delete student by ID",
     *      description="Delete student by its ID",
     *      @OA\Parameter(
     *          name="ID",
     *          description="Student ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:projects", "read:projects"}
     *         }
     *     },
     * )
     */
    public function deleteStudent(Request $request)
    {
        $student_id = $request->student_id;
        Student::where('students.id', '=', $student_id)
        ->delete();

        return 'Student ' . $student_id . ' was successfully deleted';
    }

    /**
     * @OA\Get(
     *      path="/api/v1/students/all/courses",
     *      operationId="getListOfStudentsAndTheirCourses",
     *      tags={"StudentsCourses"},
     *      summary="Get list of students and courses they are related on",
     *      description="Returns list of students and their courses",
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:projects", "read:projects"}
     *         }
     *     },
     * )
     */

    public function allStudentsCourses()
    {
        StudentsAllCoursesResource::collection(CourseStudent::join('courses', 'courses.id', '=', 'course_students.course_id')->join('students', 'students.id', '=', 'course_students.student_id')->select('students.first_name', 'students.last_name', 'courses.name')->get());

        return response()->json();
    }

    /**
    * @OA\Post(
    *     path="/api/v1/student/{student_id}/course/add",
    *     summary="Adds a new course to student",
    *     @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="course",
    *                     type="string"
    *                 ),
    *                 @OA\Property(
    *                     property="student_id",
    *                     type="intenger"
    *                 ),
    *                 example={"course": "Math", "student_id": "26"}
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="OK",
    *         @OA\JsonContent(
    *             oneOf={
    *                 @OA\Schema(ref="#/components/schemas/Result"),
    *                 @OA\Schema(type="boolean")
    *             },
    *             @OA\Examples(example="result", value={"success": true}, summary="An result object."),
    *             @OA\Examples(example="bool", value=false, summary="A boolean value."),
    *         )
    *     )
    * )
    */

    public function addStudentToCourse(Request $request, $student_id)
    {
        CourseStudent::insert([
            "student_id" => $student_id,
            "course_id" => Course::select('courses.id')->where('courses.name', $request->course)->first()->id,
        ]);

        return 'Course ' . $request->course . ' was added to student ' . $student_id;
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/student/{student_id}/course/delete",
     *      tags={"Students"},
     *      summary="Delete",
     *      description="Delete course from student",
     *      @OA\Parameter(
     *          name="Student ID",
     *          description="Student ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="Course ID",
     *          description="Course ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:projects", "read:projects"}
     *         }
     *     },
     * )
     */

    public function deleteStudentFromCourse(Request $request, $student_id)
    {
        $data = Course::select('courses.id')->where('courses.name', '=', $request->course)->first()->id;

        CourseStudent::where('course_students.student_id', '=', $student_id)
         ->where('course_students.course_id', '=', $data)
         ->delete();

        return 'Course ' . $request->course . ' was deleted from student ' . $student_id;
    }

}
