<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'day',
        'hour',
        'subject',
        'teacher_id',
    ];

    // Define the relationship with ClassModel
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // Define the relationship with Teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
