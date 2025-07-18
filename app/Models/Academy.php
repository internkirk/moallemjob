<?php

namespace App\Models;

use App\Models\AcademyLevel;
use Illuminate\Database\Eloquent\Model;
use App\Models\AcademyAdditionalInformation;

class Academy extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'website',
        'students_number',
        'province',
        'city',
        'short_description',
        'logo',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function academyAdditionalInformation()
    {
        return $this->hasOne(AcademyAdditionalInformation::class);
    }
    public function academyLevel()
    {
        return $this->hasMany(AcademyLevel::class);
    }

    public function primeAcademy()
    {
        return $this->hasOne(PrimeAcademy::class);
    }
    
     public function primeAcademyRequest()
    {
        return $this->hasOne(PrimeAcademyRequest::class);
    }
    
    public function primeAcademyResponse()
    {
        return $this->hasOne(PrimeAcademyResponse::class);
    }


    public function isPrime()
    {
        $res = $this->primeAcademy();

        // dd($res->get());

        if ($res->get()->isEmpty()) {
            return false;
        }

        return true;
    }

    public function getRelationTableName($relationMethod)
    {
        $relation = $this->$relationMethod();
        if ($relation instanceof \Illuminate\Database\Eloquent\Relations\Relation) {
            return $relation->getRelated()->getTable();
        }
        return null;
    }
}
