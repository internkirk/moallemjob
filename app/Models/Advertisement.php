<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Models\AdvertisementEducation;
use App\Models\AdvertisementJobSalary;
use App\Models\AdvertisementSoftSkill;
use Illuminate\Database\Eloquent\Model;
use App\Models\AdvertisementJobLocation;
use App\Models\AdvertisementJobBackground;
use App\Models\AdvertisementJobDescription;
use App\Models\AdvertisementJobRequirements;
use App\Models\AdvertisementAdditionalCondition;

class Advertisement extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'is_featured',
        'is_urgent'
    ];
    
    public function resumeAdvertisement()
    {
        return $this->hasMany(ResumeAdvertisement::class);
    }

    public function userAdWatch()
    {
        return $this->hasMany(UserAdWatch::class);
    }
    public function userAdLike()
    {
        return $this->hasMany(UserAdLike::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function adWatchCount()
    {
        return $this->hasOne(AdWatchCount::class);
    }
    public function jobIntroduction()
    {
        return $this->hasOne(AdvertisementJobIntroduction::class);
    }
    public function location()
    {
        return $this->hasOne(AdvertisementJobLocation::class);
    }
    public function requirement()
    {
        return $this->hasOne(AdvertisementJobRequirements::class);
    }
    public function salary()
    {
        return $this->hasOne(AdvertisementJobSalary::class);
    }
    public function jobBackground()
    {
        return $this->hasOne(AdvertisementJobBackground::class);
    }
    public function additionalCondition()
    {
        return $this->hasOne(AdvertisementAdditionalCondition::class);
    }
    public function education()
    {
        return $this->hasMany(AdvertisementEducation::class);
    }
    public function softSkill()
    {
        return $this->hasMany(AdvertisementSoftSkill::class);
    }
    public function jobDescription()
    {
        return $this->hasOne(AdvertisementJobDescription::class);
    }
    
     public function receivedResumesCount()
    {
        return $this->resumeAdvertisement()->whereNot('status', 'ارسال شده')->get()->count();
    }
    
     public function confirmedResumesCount()
    {
        return $this->resumeAdvertisement()->where('status', 'تایید برای مصاحبه')->get()->count();
    }
    public function allConfirmedResumesCount()
    {
        return ResumeAdvertisement::where('advertisement_id', $this->id)->where('status', 'تایید برای مصاحبه')->get()->count();
    }

    public function allRecivedResumesCount()
    {
        return ResumeAdvertisement::where('advertisement_id', $this->id)->get()->count();
    }


    public function advertisementExpired()
    {
        return $this->user->userPlan?->plan->declaration_expire_days < Carbon::parse($this->created_at)->diffInDays(now());
    }
    
    public function userIdForAdLiked()
    {
        $id_array = [];

        foreach ($this->userAdLike as $key => $record) {
           $id_array[] = $record->user_id;
        }

        return array_unique($id_array);
    }
}
