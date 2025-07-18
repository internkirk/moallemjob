<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicBackground extends Model
{
    protected $fillable = [
        'teacher_id',
        'major',
        'university',
        'gpa',
        'year_of_graduation',
        'is_high_school',
        'is_associate',
        'is_bachelor',
        'is_master',
        'is_phd'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
