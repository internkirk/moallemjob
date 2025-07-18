<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthCode extends Model
{
    protected $fillable = [
        'phone',
        'code'
    ];
}
