<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrimeTeacherResponse extends Model
{
    protected $fillable = [
        'teacher_id',
        'request_id',
        'text'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function request()
    {
        return $this->belongsTo(PrimeTeacherRequest::class);
    }
}
