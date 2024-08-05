<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Group::factory(10)->create();
        $this->call(CourseSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(CourseStudentSeeder::class);
    }
}
