<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrimeTeacher extends Model
{
    protected $fillable = [
        'teacher_id'
    ];


    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
