<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResumeAdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return [
            'آیدی رکورد' => $this->id ,
            'آیدی آگهی' => $this->advertisement->id,
            'منتشر کننده' => $this->advertisement->user?->first_name . " " . $this->advertisement->user?->last_name,
            'وضعیت نمایش' => $this->advertisement?->status ? true : false,
            'برجسته' => $this->advertisement?->is_featured ? true : false,
            'معرفی شغل' => [
                'عنوان شغل' => $this->advertisement->jobIntroduction?->job_title,
                'مقطع تحصیلی' => $this->advertisement->jobIntroduction?->academic_level,
                'سمت' => $this->advertisement->jobIntroduction?->school_role,
                'پایه تحصیلی' => $this->advertisement->jobIntroduction?->academic_section,
                'رشته' => $this->advertisement->jobIntroduction?->major,
                'نوع همکاری' => $this->advertisement->jobIntroduction?->cooperation_type,
            ],
            'موقعیت محل کار' => [
                'استان' => $this->advertisement->location?->province,
                'شهر' => $this->advertisement->location?->city,
            ],
            'شرایط احراز شغل' => [
                'حداقل سن' => $this->advertisement->requirement?->min_age,
                'حداکثر سن' => $this->advertisement->requirement?->max_age,
                'جنسیت' => $this->advertisement->requirement?->sex,
            ],
            'حقوق و مزایا' => [
                'حداقل حقوق' => $this->advertisement->salary?->min_salary,
                'حداکثر حقوق' => $this->advertisement->salary?->max_salary,
                'مزایا و تسهیلات' => $this->advertisement->salary?->benefits,
            ],
            'سابقه کار' => [
                'جذب به عنوان کارآموز' => (is_null($this->advertisement->jobBackground) ? NULL : ($this->advertisement->jobBackground?->as_intern ? true : false)),
                'داشتن سابقه الزامی است' => (is_null($this->advertisement->jobBackground) ? NULL : ($this->advertisement->jobBackground?->must_have_background ? true : false)),
                'میزان سابقه' => $this->advertisement->jobBackground?->background,
            ],
            'شرایط تکمیلی' => [
                'اتمام خدمت سربازی یا معافیت' => (is_null($this->advertisement->additionalCondition) ? NULL : ($this->advertisement->additionalCondition?->military_service ? true : false)),
                'گواهی گزینش' => (is_null($this->advertisement->additionalCondition) ? NULL : ($this->advertisement->additionalCondition?->selection_certificate ? true : false)),
                'گواهی عدم سوء پیشینه' => (is_null($this->advertisement->additionalCondition) ?: ($this->advertisement->additionalCondition?->no_crime_certificate ? true : false)),
            ],
            'تحصیلات' => [
                AdvertisementEducationResource::collection($this->advertisement?->education)
            ],
            'مهارت های نرم افزاری' => [
                AdvertisementSoftSkillResource::collection($this->advertisement?->softSkill)
            ],
            'شرح شغل' => [
                'ساعت و روز کاری' => $this->advertisement->jobDescription?->job_time,
                'شرح کلی شغل و مهارت های مورد نیاز' => $this->advertisement->jobDescription?->job_description,
            ]
            ,
            'فوری بودن و نمایش متمایز آگهی' => $this->advertisement->user?->userPlan?->plan?->is_suggested_resume ? true : false,
            'ذخیره شده' => $this->advertisement->userIdForAdLiked(),
            'مشاهده شده' => $this->advertisement->adWatchCount?->count ?  $this->advertisement->adWatchCount?->count : 0,
            'تاریخ ارسال' =>  Verta($this->created_at)->formatJalaliDate(),
            'تاریخ ویرایش' =>  Verta($this->updated_at)->formatJalaliDate(),
            'وضعیت' => $this->status
        ];
    }
}
