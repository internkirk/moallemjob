<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobExperience extends Model
{
    protected $fillable = [
        'teacher_id',
        'text'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
