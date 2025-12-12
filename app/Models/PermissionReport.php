<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermissionReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'student_name',
        'permission_date',
        'permission_time',
        'permission_type',
        'reason',
        'status'
    ];

    protected $casts = [
        'permission_date' => 'date',
        'permission_time' => 'string',  // Changed from 'time' to 'string' since 'time' cast doesn't exist
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
