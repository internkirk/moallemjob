<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //   dd(AcademyResource::collection([$this->user->academy]));
       

            return [
                'آیدی' => $this?->id,
                'منتشر کننده' => $this->user?->first_name . " " . $this->user?->last_name,
                'وضعیت' => $this?->status ? true : false,
                'برجسته' => $this?->is_featured ? true : false,
                'معرفی شغل' => [
                    'عنوان شغل' => $this->jobIntroduction?->job_title,
                    'مقطع تحصیلی' => $this->jobIntroduction?->academic_level,
                    'سمت' => $this->jobIntroduction?->school_role,
                    'پایه تحصیلی' => $this->jobIntroduction?->academic_section,
                    'رشته' => $this->jobIntroduction?->major,
                    'نوع همکاری' => $this->jobIntroduction?->cooperation_type,
                ],
                'موقعیت محل کار' => [
                    'استان' => $this->location?->province,
                    'شهر' => $this->location?->city,
                ],
                'شرایط احراز شغل' => [
                    'حداقل سن' => $this->requirement?->min_age,
                    'حداکثر سن' => $this->requirement?->max_age,
                    'جنسیت' => $this->requirement?->sex,
                ],
                'حقوق و مزایا' => [
                    'حداقل حقوق' => $this->salary?->min_salary,
                    'حداکثر حقوق' => $this->salary?->max_salary,
                    'مزایا و تسهیلات' => $this->salary?->benefits,
                ],
                'سابقه کار' => [
                    'جذب به عنوان کارآموز' => (is_null($this->jobBackground) ? NULL : ($this->jobBackground?->as_intern ? true : false)),
                    'داشتن سابقه الزامی است' => (is_null($this->jobBackground) ? NULL : ($this->jobBackground?->must_have_background ? true : false)),
                    'میزان سابقه' => $this->jobBackground?->background,
                ],
                'شرایط تکمیلی' => [
                    'اتمام خدمت سربازی یا معافیت' => (is_null($this->additionalCondition) ? NULL : ($this->additionalCondition?->military_service ? true : false)),
                    'گواهی گزینش' => (is_null($this->additionalCondition) ? NULL : ($this->additionalCondition?->selection_certificate ? true : false)),
                    'گواهی عدم سوء پیشینه' => (is_null($this->additionalCondition) ?: ($this->additionalCondition?->no_crime_certificate ? true : false)),
                ],
                'تحصیلات' => [
                    AdvertisementEducationResource::collection($this?->education)
                ],
                'مهارت های نرم افزاری' => [
                    AdvertisementSoftSkillResource::collection($this?->softSkill)
                ],
                'شرح شغل' => [
                    'ساعت و روز کاری' => $this->jobDescription?->job_time,
                    'شرح کلی شغل و مهارت های مورد نیاز' => $this->jobDescription?->job_description,
                ]
                ,
                'فوری بودن و نمایش متمایز آگهی' =>$this->is_urgent ? true : false,
                'ذخیره شده' => $this->userIdForAdLiked(),
                 'مشاهده شده'=>$this->adWatchCount?->count ?  $this->adWatchCount?->count : 0,
                 'اطلاعات آموزشگاه' => [
                    "id" => $this->user?->academy?->id,
                    "name" => $this->user?->academy?->name,
                    "phone" => $this->user?->academy?->phone,
                    "website" => $this->user?->academy?->website,
                    "students_number" => $this->user?->academy?->students_number,
                    "province" => $this->user?->academy?->province,
                    "city" => $this->user?->academy?->city,
                    "short_description" => $this->user?->academy?->short_description,
                    "logo" => $this->user?->academy?->logo,
                    "description" => $this->user?->academy?->description,
                    "created_at" => $this->user?->academy?->created_at,
                    "updated_at" => $this->user?->academy?->updated_at,
                    "اطلاعات تکمیلی" => [
                        'سال تاسیس' => $this->user?->academy?->academyAdditionalInformation?->establishment_year,
                        ' تصویر مجوز تاسیس' => $this->user?->academy?->academyAdditionalInformation?->establishment_license_image,
                        'تصویر مجوز راه اندازی' => $this->user?->academy?->academyAdditionalInformation?->startup_license_image,
                        'تصویر نمایه' => $this->user?->academy?->academyAdditionalInformation?->profile_image,
                        'تصاویر مدرسه' => $this->user?->academy?->academyAdditionalInformation?->school_image,
                        'مزایا و تسهیلات سازمانی' => $this->user?->academy?->academyAdditionalInformation?->benefits
                    ],
                    "مقاطع تحصیلی" => [
                        $this->user?->academy?->academyLevel
                    ],
                    'آموزشگاه برتر' => $this->user?->academy?->isPrime(),
                    'فرصت های شغلی' => $this->user?->advertisements->count(),
                ] ,
                'تعداد رزومه های ارسالی' => $this->resumeAdvertisement->count()
            ];
        
    }
}
