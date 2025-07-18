<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetResumeHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $typeOfCooperation = '';

        if ($this->resume->jobInDemand?->is_full_time) {
            $typeOfCooperation = 'تمام وقت';
        } else if ($this->resume->jobInDemand?->is_half_time) {
            $typeOfCooperation = 'نیمه وقت';
        } else if ($this->resume->jobInDemand?->is_part_time) {
            $typeOfCooperation = 'پاره وقت';
        }

        return [
            'آیدی رکورد' => $this->id,
            'آیدی کاربر' => $this->resume->user->id,
            'آیدی رزومه' => $this->resume->id,
            'نام' => $this->resume->first_name,
            'نام خانوادگی' => $this->resume->last_name,
            'جنسیت' => $this->resume->is_male ? 'مرد' : 'زن',
            'وضعیت تاهل' => $this->resume->is_single ? 'مجرد' : 'متاهل',
            'سن' => $this->resume->age,
            'شماره همراه' => $this->resume->phone,
            'سابقه تدریس' => $this->resume->jobBackgrounds?->teaching_exp,
            'ایمیل' => $this->resume->email,
            'شهر' => $this->resume->city,
            'استان' => $this->resume->province,
            'گزینش' => $this->resume->is_selected ? 'دارد' : 'ندارد',
            'تصویر گزینش' => $this->resume->selection_image,
            'عکس' => $this->resume->avatar,
            'توضیحات' => $this->resume->description,
            'سوابق تحصیلی' => [
                'مقطع تحصیلی' => [
                    'متوسطه' => $this->resume->academicBackground?->is_high_school,
                    'کاردانی' => $this->resume->academicBackground?->is_associate,
                    'کارشناسی' => $this->resume->academicBackground?->is_bachelor,
                    'کارشناسی ارشد' => $this->resume->academicBackground?->is_master,
                    'دکترا و بالاتر' => $this->resume->academicBackground?->is_phd,
                ],
                'رشته تحصیلی' => $this->resume->academicBackground?->major,
                'دانشگاه' => $this->resume->academicBackground?->university,
                'معدل' => $this->resume->academicBackground?->gpa,
                'سال فارغ التحصیلی' => $this->resume->academicBackground?->year_of_graduation,
            ],
            'سوابق شغلی' => [
                'مقطع تحصیلی' => [
                    'پیش دبستانی' => $this->resume->jobBackgrounds?->is_pre_school,
                    'ابتدایی' => $this->resume->jobBackgrounds?->is_elementary,
                    'متوسطه اول' => $this->resume->jobBackgrounds?->is_middle_school,
                    'متوسطه نظری' => $this->resume->jobBackgrounds?->is_high_school,
                    'هنرستان' => $this->resume->jobBackgrounds?->is_techinical_college,
                    'مدرس زبان خارجی' => $this->resume->jobBackgrounds?->is_foreign_lan_teacher,
                    'مدرس کنکور' => $this->resume->jobBackgrounds?->is_entrance_exam_teacher,
                    'مشاور تحصیلی و تربیتی' => $this->resume->jobBackgrounds?->is_academic_counsellor,
                ],
                'سمت' => [
                    'مدیر' => $this->resume->jobBackgrounds?->is_manager,
                    'مربی' => $this->resume->jobBackgrounds?->is_couch,
                    'معاون' => $this->resume->jobBackgrounds?->is_deputy,
                    'آموزگار' => $this->resume->jobBackgrounds?->is_teacher,
                    'دبیر' => $this->resume->jobBackgrounds?->is_dabir,
                    'هنرآموز' => $this->resume->jobBackgrounds?->is_honar_amouz,
                ],
                'رشته تحصیلی' => $this->resume->jobBackgrounds?->major,
                'شهر' => $this->resume->jobBackgrounds?->city,
                'آموزشگاه' => $this->resume->jobBackgrounds?->school,
                'سال شروع' => $this->resume->jobBackgrounds?->start_year,
                'سال پایان' => $this->resume->jobBackgrounds?->end_year
            ],
            'مهارت ها' => [
                SoftSkillForSuggestedResumeResource::collection($this->resume->skills)
            ],
            'مشاغل درخواستی' => [
                'رشته تحصیلی' => $this->resume->jobInDemand?->major,
                'شهر' => $this->resume->jobInDemand?->city,
                'استان' => $this->resume->jobInDemand?->province,
                'حقوق درخواستی' => $this->resume->jobInDemand?->salary,
                'مقطع تحصیلی' => [
                    'پیش دبستانی' => $this->resume->jobInDemand?->is_pre_school,
                    'ابتدایی' => $this->resume->jobInDemand?->is_elementary,
                    'متوسطه اول' => $this->resume->jobInDemand?->is_middle_school,
                    'متوسطه نظری' => $this->resume->jobInDemand?->is_high_school,
                    'هنرستان' => $this->resume->jobInDemand?->is_techinical_college,
                    'مدرس زبان خارجی' => $this->resume->jobInDemand?->is_foreign_lan_teacher,
                    'مدرس کنکور' => $this->resume->jobInDemand?->is_entrance_exam_teacher,
                    'مشاور تحصیلی و تربیتی' => $this->resume->jobInDemand?->is_academic_counsellor,
                ],
                'سمت' => [
                    'مدیر' => $this->resume->jobInDemand?->is_manager,
                    'مربی' => $this->resume->jobInDemand?->is_couch,
                    'معاون' => $this->resume->jobInDemand?->is_deputy,
                    'آموزگار' => $this->resume->jobInDemand?->is_teacher,
                    'دبیر' => $this->resume->jobInDemand?->is_dabir,
                    'هنرآموز' => $this->resume->jobInDemand?->is_honar_amouz,
                ],
                'نوع همکاری' => $typeOfCooperation
            ],
            'تاریخ ویرایش' =>  Verta($this->updated_at)->formatJalaliDate(),
            'معلم برتر' => $this->resume->isPrime(),
            'وضعیت' => $this->status
        ];
    }
}
