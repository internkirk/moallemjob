<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrimeTeacherRequest extends Model
{
    protected $fillable = [
        'teacher_id',
        'status',
        'files'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
