<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'address',
        'profile_image',
        'class_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // A student belongs to a class
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // A student has many guardians
    public function guardians()
    {
        return $this->hasMany(Guardian::class, 'student_id');
    }

    // A student has many permission reports
    public function permissionReports()
    {
        return $this->hasMany(PermissionReport::class, 'student_id');
    }

    // Get full name attribute
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
