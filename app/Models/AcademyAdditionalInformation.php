<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademyAdditionalInformation extends Model
{
    protected $fillable = [
        'academy_id',
        'establishment_year',
        'establishment_license_image',
        'startup_license_image',
        'profile_image',
        'benefits',
        'school_image'
    ];
}
