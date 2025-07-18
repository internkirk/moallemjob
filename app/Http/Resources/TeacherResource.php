<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {


        $academicLevel = '';

        $jobBackgroundAcademicLevel = '';
        
        $schoolRole = '';

        $academicLevelForJobInDemand = '';

        $schoolRoleForJobInDemand = '';

        $typeOfCooperation = '';

        if ($this->academicBackground?->is_high_school) {
            $academicLevel = 'متوسطه';
        } else if ($this->academicBackground?->is_associate) {
            $academicLevel = 'کاردانی';
        } else if ($this->academicBackground?->is_bachelor) {
            $academicLevel = 'کارشناسی';
        } else if ($this->academicBackground?->is_master) {
            $academicLevel = 'کارشناسی ارشد';
        } else if ($this->academicBackground?->is_phd) {
            $academicLevel = 'دکترا و بالاتر';
        }


        if ($this->jobBackgrounds?->is_pre_school) {
            $jobBackgroundAcademicLevel = 'پیش دبستانی';
        } else if ($this->jobBackgrounds?->is_elemantary) {
            $jobBackgroundAcademicLevel = 'ابتدایی';
        } else if ($this->jobBackgrounds?->is_middle_school) {
            $jobBackgroundAcademicLevel = 'متوسطه اول';
        } else if ($this->jobBackgrounds?->is_high_school) {
            $jobBackgroundAcademicLevel = 'متوسطه نظری';
        } else if ($this->jobBackgrounds?->is_techinical_college) {
            $jobBackgroundAcademicLevel = 'هنرستان';
        }
         else if ($this->jobBackgrounds?->is_foreign_lan_teacher) {
            $jobBackgroundAcademicLevel = 'مدرس زبان خارجی';
        }
         else if ($this->jobBackgrounds?->is_entrance_exam_teacher) {
            $jobBackgroundAcademicLevel = 'مدرس کنکور';
        }
         else if ($this->jobBackgrounds?->is_academic_counsellor) {
            $jobBackgroundAcademicLevel = 'مشاور تحصیلی و تربیتی';
        }


        if ($this->jobBackgrounds?->is_deputy) {
            $schoolRole = 'مدیر';
        } else if ($this->jobBackgrounds?->is_couch) {
            $schoolRole = 'مربی';
        } else if ($this->jobBackgrounds?->is_teacher) {
            $schoolRole = 'آموزگار';
        } else if ($this->jobBackgrounds?->is_dabir) {
            $schoolRole = 'دبیر';
        } else if ($this->jobBackgrounds?->is_honar_amouz) {
            $schoolRole = 'هنرآموز';
        }


        if ($this->jobInDemand?->is_pre_school) {
            $academicLevelForJobInDemand = 'پیش دبستانی';
        } else if ($this->jobInDemand?->is_elemantary) {
            $academicLevelForJobInDemand = 'ابتدایی';
        } else if ($this->jobInDemand?->is_middle_school) {
            $academicLevelForJobInDemand = 'متوسطه اول';
        } else if ($this->jobInDemand?->is_high_school) {
            $academicLevelForJobInDemand = 'متوسطه نظری';
        } else if ($this->jobInDemand?->is_techinical_college) {
            $academicLevelForJobInDemand = 'هنرستان';
        }
         else if ($this->jobInDemand?->is_foreign_lan_teacher) {
            $academicLevelForJobInDemand = 'مدرس زبان خارجی';
        }
         else if ($this->jobInDemand?->is_entrance_exam_teacher) {
            $academicLevelForJobInDemand = 'مدرس کنکور';
        }
         else if ($this->jobInDemand?->is_academic_counsellor) {
            $academicLevelForJobInDemand = 'مشاور تحصیلی و تربیتی';
        }

        if ($this->jobInDemand?->is_deputy) {
            $schoolRoleForJobInDemand = 'مدیر';
        } else if ($this->jobInDemand?->is_couch) {
            $schoolRoleForJobInDemand = 'مربی';
        } else if ($this->jobInDemand?->is_teacher) {
            $schoolRoleForJobInDemand = 'آموزگار';
        } else if ($this->jobInDemand?->is_dabir) {
            $schoolRoleForJobInDemand = 'دبیر';
        } else if ($this->jobInDemand?->is_honar_amouz) {
            $schoolRoleForJobInDemand = 'هنرآموز';
        }


        if ($this->jobInDemand?->is_full_time) {
            $typeOfCooperation = 'تمام وقت';
        } else if ($this->jobInDemand?->is_half_time) {
            $typeOfCooperation = 'نیمه وقت';
        } else if ($this->jobInDemand?->is_part_time) {
            $typeOfCooperation = 'پاره وقت';
        }

        return [
            'آیدی کاربر' => $this->user->id,
            'id' => $this->id,
            'نام' => $this->first_name,
            'نام خانوادگی' => $this->last_name,
            'جنسیت' => $this->is_male ? 'مرد' : 'زن',
            'وضعیت تاهل' => $this->is_single ? 'مجرد' : 'متاهل',
            'سن' => $this->age,
            'شماره همراه' => $this->phone,
            'سابقه تدریس' => $this->jobBackgrounds?->teaching_exp,
            'ایمیل' => $this->email,
            'شهر' => $this->city,
            'استان' => $this->province,
            'گزینش' => $this->is_selected ? 'دارد' : 'ندارد',
            'تصویر گزینش' => $this->selection_image,
            'عکس' => $this->avatar,
            'توضیحات' => $this->description,
            'سوابق تحصیلی' => [
                'مقطع تحصیلی' => $academicLevel,
                'رشته تحصیلی' => $this->academicBackground?->major,
                'دانشگاه' => $this->academicBackground?->university,
                'معدل' => $this->academicBackground?->gpa,
                'سال فارغ التحصیلی' => $this->academicBackground?->year_of_graduation,
            ],
            'سوابق شغلی' => [
                'مقطع تحصیلی' => $jobBackgroundAcademicLevel,
                'سمت' => $schoolRole,
                'رشته تحصیلی' => $this->jobBackgrounds?->major,
                'شهر' => $this->jobBackgrounds?->city,
                'آموزشگاه' => $this->jobBackgrounds?->school,
                'سال شروع' =>  $this->jobBackgrounds?->start_year,
                'سال پایان' =>  $this->jobBackgrounds?->end_year
            ],
            'مهارت ها' => [
                SoftSkillForSuggestedResumeResource::collection($this->skills)
            ],
            'مشاغل درخواستی' => [
                'رشته تحصیلی' => $this->jobInDemand?->major,
                'شهر' => $this->jobInDemand?->city,
                'استان' => $this->jobInDemand?->province,
                'حقوق درخواستی' => $this->jobInDemand?->salary,
                'مقطع تحصیلی' => $academicLevelForJobInDemand,
                'سمت' => $schoolRoleForJobInDemand,
                'نوع همکاری' =>$typeOfCooperation
            ],
            'معلم برتر' => $this->isPrime()
        ];
    }
}
