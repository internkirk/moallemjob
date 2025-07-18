<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalResumeRequest extends Model
{
    protected $fillable = [
        'teacher_id',
        'description',
        'status',
        'request_stage'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    
    public function tickets()
    {
        return $this->hasMany(ProResumeTicket::class,'request_id','id');
    }
}
