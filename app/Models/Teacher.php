<?php

namespace App\Models;

use App\Models\PrimeTeacher;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'is_male',
        'is_single',
        'age',
        'phone',
        'email',
        'city',
        'province',
        'is_selected',
        'selection_image',
        'description',
        'avatar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function academicBackground()
    {
        return $this->hasOne(AcademicBackground::class);
    }

    public function jobBackgrounds()
    {
        return $this->hasOne(JobBackground::class);
    }

    public function jobInDemand()
    {
        return $this->hasOne(JobInDemand::class);
    }

    public function primeTeacher()
    {
        return $this->hasOne(PrimeTeacher::class);
    }
    
    public function jobExperience()
    {
        return $this->hasMany(JobExperience::class, 'teacher_id','id');
    }
    
    public function advertisementResume()
    {
        return $this->hasMany(ResumeAdvertisement::class, 'resume_id', 'id');
    }

    public function isPrime()
    {
        $res = $this->primeTeacher();

        if ($res->get()->isEmpty()) {
            return false;
        }

        return true;
    }


    public function isResumeCompleted()
    {
        $academicBackground = $this->academicBackground();
        $jobBackgrounds = $this->jobBackgrounds();
        $jobInDemand = $this->jobInDemand();


        if($academicBackground->first() != NULL && $jobBackgrounds->first() != NULL && $jobInDemand->first() != NULL){
            return true;
        }

        return false;
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
