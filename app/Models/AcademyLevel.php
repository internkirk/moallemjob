<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademyLevel extends Model
{
    protected $fillable = [
        'title',
        'academy_id'
    ];


    public function academy()
    {
        return $this->belongsTo(Academy::class, 'academy_id', 'id');
    }
}
