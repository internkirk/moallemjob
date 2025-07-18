<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdWatchCount extends Model
{
    protected $fillable = [
        'advertisement_id',
        'count',
    ];
}
