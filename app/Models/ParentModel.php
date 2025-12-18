<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    protected $table = 'parents'; // Explicitly set the table name to match the renamed table

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'relationship',
        'student_id',
    ];

    // A parent belongs to a student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Get full name attribute
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
