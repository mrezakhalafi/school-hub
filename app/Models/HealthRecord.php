<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class HealthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'height',
        'weight',
        'blood_pressure',
        'vision_test_result',
        'hearing_test_result',
        'dental_health',
        'allergies',
        'medical_conditions',
        'medications',
        'emergency_contact',
        'immunization_records',
        'date_checked',
        'checked_by'
    ];

    protected $casts = [
        'date_checked' => 'date',
        'allergies' => 'array',
        'medical_conditions' => 'array',
        'immunization_records' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}