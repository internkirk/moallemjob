<?php

namespace App\Models;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;

class JobInDemand extends Model
{
    protected $fillable = [
        'teacher_id',
        'major',
        'payeh',
        'salary',
        'province',
        'city',
        'is_pre_school',
        'is_elementary',
        'is_middle_school',
        'is_high_school',
        'is_techinical_college',
        'is_foreign_lan_teacher',
        'is_entrance_exam_teacher',
        'is_academic_counsellor',
        'is_manager',
        'is_deputy',
        'is_couch',
        'is_teacher',
        'is_dabir',
        'is_honar_amouz',
        'is_full_time',
        'is_half_time',
        'is_part_time',
    ];


    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
