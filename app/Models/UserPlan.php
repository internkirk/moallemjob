<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class UserPlan extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id'
    ];


    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function suggestedJobsNumberLimitation()
    {
       return $this->plan->outstanding_job_quantity;
    }

    public function suggestedResumesNumberLimitation()
    {
       return $this->plan->suggested_resume_quantity;
    }

      public function isExpired()
    {
        $created = Carbon::parse($this->created_at)->diffInDays(now());

        if ($created > $this->plan->declaration_expire_days) {
            return true;
        }

        return false;
    }
    public function remainingDays()
    {
        $created = Carbon::parse($this->created_at)->diffInDays(now());

        $result = round($this->plan->declaration_expire_days - $created);

        if ($result < 0)
            return 'منقضی شده';

        return $result;
    }
   
}
