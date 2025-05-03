<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolHoliday extends Model
{
    use HasFactory;

    protected $table = 'school_holiday';

    protected $fillable = [
        'uuid',
        'start_date',
        'end_date',
        'name',
        'regional_scope',
        'temporal_scope',
        'nationwide',
        'subdivisions',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'nationwide' => 'boolean',
        'subdivisions' => 'array',
    ];
}
