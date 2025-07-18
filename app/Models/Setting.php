<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'logo',
        'about_us',
        'contact_us',
        'site_title',
        'questions',
        'enamad'
    ];
}
