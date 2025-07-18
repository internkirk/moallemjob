<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeAdvertisement extends Model
{
    protected $fillable = [
        'advertisement_id',
        'resume_id',
        'status'
    ];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
    public function resume()
    {
        return $this->belongsTo(Teacher::class,'resume_id','id');
    }
}
