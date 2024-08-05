<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table("courses")->insert([
            [
                "name" => "Science",
                "description" => "Agriculture Astronomy Biology Botany Chemistry Earth science Geology Marine biology Oceanography Physics Zoology",
            ],
            [
                "name" => "Computer Science",
                "description" => "Animation App development Audio production Computer programming Film production Graphic design Media technology Web programming Word processing",
            ],
            [
                "name" => "English",
                "description" => "British literature Humanities Journalism Literary analysis Modern literature Poetry World literature ",
            ],
            [
                "name" => "Foreign Language",
                "description" => "Ancient Greek Arabic Chinese French German Hebrew Italian Japanese Korean Latin Portuguese Russian Spanish",
            ],
            [
                "name" => "Math",
                "description" => 'Algebra Geometry Integrated math Math applications Pre-algebra Probability Quantitative literacy Statistics Trigonometry',
            ],
            [
                'name' => 'Performing Arts',
                'description' => 'Choir Dance Guitar Music theory Orchestra Piano',
            ],
            [
                'name' => 'Physical Education',
                'description' => 'Aerobics Dance Gymnastics Swimming Yoga',
            ],
            [
                'name' => 'Social Studies',
                'description' => 'Cultural anthropology European history Geography Human geography International relations Law Physical anthropology Political studies Psychology',
            ],
            [
                'name' => 'Visual Arts',
                'description' => '3-D art Ceramics Drawing Jewelry design Painting Photography',
            ],
            [
                'name' => 'Vocational Education',
                'description' => 'Auto body repair Criminal justice Driver education Heating and cooling systems Hospitality and tourism Robotics Woodworking',
            ]
            ]);
    }
}
