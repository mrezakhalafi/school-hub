<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolInformation extends Model
{
    protected $fillable = [
        'school_name',
        'head_of_school',
        'location',
        'history',
        'building_features',
        'extracurricular_activities',
        'accreditation',
        'founding_year',
        'student_capacity',
    ];
}
