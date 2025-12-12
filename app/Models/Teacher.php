<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'birth_date',
        'gender',
        'address',
        'profile_image',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // A teacher can be a class advisor for one class
    public function class()
    {
        return $this->hasOne(ClassModel::class, 'teacher_id');
    }

    // Get full name attribute
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
