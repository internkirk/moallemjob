<?php

namespace App\Models;

use App\Models\Academy;
use Illuminate\Database\Eloquent\Model;

class PrimeAcademyResponse extends Model
{
    protected $fillable = [
        'request_id',
        'academy_id',
        'text'
    ];

    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }
    public function request()
    {
        return $this->belongsTo(PrimeAcademyRequest::class);
    }
}
