<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Plan extends Model
{
    protected $fillable = [
        'title',
        'status',
        'price',
        'declaration_expire_days',
        'recruitment_declaration_quantity',
        'outstanding_job_quantity',
        'outstanding_job_expire_time',
        'telegram_declaration',
        'email_declaration',
        'sms_declaration',
        'suggested_resume_quantity',
        'is_full_time_support',
        'is_suggested_resume',
        'is_one_and_half_possibility_in_search_results',
        'is_two_possibility_in_search_results',
        'is_one_and_half_possibility_to_visit_by_job_seekers',
        'is_two_possibility_to_visit_by_job_seekers',
        'show_declaration_analytics',
        'access_to_best_teachers_list',
        'design_specific_plan',
        'specialized_advice',
        'adding_specific_features',
        'recruitment_declaration_advice',
        'recruitment_specific_support',
        'screening_resume_support',
        'urgent_lable_expire_time',
        'is_suggested'
    ];


    public function userPlan()
    {
        return $this->hasMany(UserPlan::class);
    }
    
    public function isExpired()
    {
        $this->declaration_expire_days;

        $created = Carbon::parse($this->create_at)->diffInDays(now());

        if ($created > $this->declaration_expire_days) {
            return true;
        }

        return false;
    }
}
