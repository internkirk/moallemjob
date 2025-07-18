<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrimeAcademy extends Model
{
    protected $fillable = [
        'academy_id'
    ];

    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }
}
