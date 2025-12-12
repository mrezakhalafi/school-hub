<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolEvent extends Model
{
    use HasFactory;

    protected $table = 'events'; // Specify the events table name

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'event_type',
        'is_published',
        'image',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_published' => 'boolean',
    ];
}
