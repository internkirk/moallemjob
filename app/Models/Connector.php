<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connector extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'school_role',
        'phone'
    ];
}
