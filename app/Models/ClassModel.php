<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes'; // Specify the correct table name

    protected $fillable = [
        'name',
        'level',
        'major',
        'section',
        'teacher_id',
        'description',
    ];

    // A class has one teacher as advisor
    public function advisor()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    // A class has many students
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    // A class has many schedules
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }
}
