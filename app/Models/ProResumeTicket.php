<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProResumeTicket extends Model
{
    protected $fillable = [
        'request_id',
        'text',
        'file',
        'is_admin'
    ];

    public function request()
    {
        return $this->belongsTo(ProfessionalResumeRequest::class);
    }
}
