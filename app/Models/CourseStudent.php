<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    use HasFactory;

    protected $table = 'course_students';
    protected $guarded = false;

    protected $fillable = [
        'student_id',
        'course_id',
    ];
}
