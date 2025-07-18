<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureManager extends Model
{
    protected $fillable = [
        'feature',
        'fa_title',
        'status'
    ];
}
