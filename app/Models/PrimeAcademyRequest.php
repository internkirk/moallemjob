<?php

namespace App\Models;

use App\Models\Academy;
use Illuminate\Database\Eloquent\Model;

class PrimeAcademyRequest extends Model
{
    protected $fillable = [
        'academy_id',
        'status',
        'files'
    ];

    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }
}
