<?php

namespace App\Services;
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
}