<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrimeTeacherResource extends JsonResource
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

        if ($this->teacher->academicBackground?->is_high_school) {
            $academicLevel = 'متوسطه';
        } else if ($this->teacher->academicBackground?->is_associate) {
            $academicLevel = 'کاردانی';
        } else if ($this->teacher->academicBackground?->is_bachelor) {
            $academicLevel = 'کارشناسی';
        } else if ($this->teacher->academicBackground?->is_master) {
            $academicLevel = 'کارشناسی ارشد';
        } else if ($this->teacher->academicBackground?->is_phd) {
            $academicLevel = 'دکترا و بالاتر';
        }


        if ($this->teacher->jobBackgrounds?->is_pre_school) {
            $jobBackgroundAcademicLevel = 'پیش دبستانی';
        } else if ($this->teacher->jobBackgrounds?->is_elemantary) {
            $jobBackgroundAcademicLevel = 'ابتدایی';
        } else if ($this->teacher->jobBackgrounds?->is_middle_school) {
            $jobBackgroundAcademicLevel = 'متوسطه اول';
        } else if ($this->teacher->jobBackgrounds?->is_high_school) {
            $jobBackgroundAcademicLevel = 'متوسطه نظری';
        } else if ($this->teacher->jobBackgrounds?->is_techinical_college) {
            $jobBackgroundAcademicLevel = 'هنرستان';
        }
         else if ($this->teacher->jobBackgrounds?->is_foreign_lan_teacher) {
            $jobBackgroundAcademicLevel = 'مدرس زبان خارجی';
        }
         else if ($this->teacher->jobBackgrounds?->is_entrance_exam_teacher) {
            $jobBackgroundAcademicLevel = 'مدرس کنکور';
        }
         else if ($this->teacher->jobBackgrounds?->is_academic_counsellor) {
            $jobBackgroundAcademicLevel = 'مشاور تحصیلی و تربیتی';
        }


        if ($this->teacher->jobBackgrounds?->is_deputy) {
            $schoolRole = 'مدیر';
        } else if ($this->teacher->jobBackgrounds?->is_couch) {
            $schoolRole = 'مربی';
        } else if ($this->teacher->jobBackgrounds?->is_teacher) {
            $schoolRole = 'آموزگار';
        } else if ($this->teacher->jobBackgrounds?->is_dabir) {
            $schoolRole = 'دبیر';
        } else if ($this->teacher->jobBackgrounds?->is_honar_amouz) {
            $schoolRole = 'هنرآموز';
        }


        if ($this->teacher->jobInDemand?->is_pre_school) {
            $academicLevelForJobInDemand = 'پیش دبستانی';
        } else if ($this->teacher->jobInDemand?->is_elemantary) {
            $academicLevelForJobInDemand = 'ابتدایی';
        } else if ($this->teacher->jobInDemand?->is_middle_school) {
            $academicLevelForJobInDemand = 'متوسطه اول';
        } else if ($this->teacher->jobInDemand?->is_high_school) {
            $academicLevelForJobInDemand = 'متوسطه نظری';
        } else if ($this->teacher->jobInDemand?->is_techinical_college) {
            $academicLevelForJobInDemand = 'هنرستان';
        }
         else if ($this->teacher->jobInDemand?->is_foreign_lan_teacher) {
            $academicLevelForJobInDemand = 'مدرس زبان خارجی';
        }
         else if ($this->teacher->jobInDemand?->is_entrance_exam_teacher) {
            $academicLevelForJobInDemand = 'مدرس کنکور';
        }
         else if ($this->teacher->jobInDemand?->is_academic_counsellor) {
            $academicLevelForJobInDemand = 'مشاور تحصیلی و تربیتی';
        }

        if ($this->teacher->jobInDemand?->is_deputy) {
            $schoolRoleForJobInDemand = 'مدیر';
        } else if ($this->teacher->jobInDemand?->is_couch) {
            $schoolRoleForJobInDemand = 'مربی';
        } else if ($this->teacher->jobInDemand?->is_teacher) {
            $schoolRoleForJobInDemand = 'آموزگار';
        } else if ($this->teacher->jobInDemand?->is_dabir) {
            $schoolRoleForJobInDemand = 'دبیر';
        } else if ($this->teacher->jobInDemand?->is_honar_amouz) {
            $schoolRoleForJobInDemand = 'هنرآموز';
        }


        if ($this->teacher->jobInDemand?->is_full_time) {
            $typeOfCooperation = 'تمام وقت';
        } else if ($this->teacher->jobInDemand?->is_half_time) {
            $typeOfCooperation = 'نیمه وقت';
        } else if ($this->teacher->jobInDemand?->is_part_time) {
            $typeOfCooperation = 'پاره وقت';
        }

        return [
            'id' => $this->teacher->id,
            'نام' => $this->teacher->first_name,
            'نام خانوادگی' => $this->teacher->last_name,
            'جنسیت' => $this->teacher->is_male ? 'مرد' : 'زن',
            'وضعیت تاهل' => $this->teacher->is_single ? 'مجرد' : 'متاهل',
            'سن' => $this->teacher->age,
            'شماره همراه' => $this->teacher->phone,
            'سابقه تدریس' => $this->jobBackgrounds?->teaching_exp,
            'ایمیل' => $this->teacher->email,
            'شهر' => $this->teacher->city,
            'استان' => $this->teacher->province,
            'گزینش' => $this->teacher->is_selected ? 'دارد' : 'ندارد',
            'عکس' => $this->teacher->avatar,
            'توضیحات' => $this->teacher->description,
            'سوابق تحصیلی' => [
                'مقطع تحصیلی' => $academicLevel,
                'رشته تحصیلی' => $this->teacher->academicBackground?->major,
                'دانشگاه' => $this->teacher->academicBackground?->university,
                'معدل' => $this->teacher->academicBackground?->gpa,
                'سال فارغ التحصیلی' => $this->teacher->academicBackground?->year_of_graduation,
            ],
            'سوابق شغلی' => [
                'مقطع تحصیلی' => $jobBackgroundAcademicLevel,
                'سمت' => $schoolRole,
                'رشته تحصیلی' => $this->teacher->jobBackgrounds?->major,
                'شهر' => $this->teacher->jobBackgrounds?->city,
                'آموزشگاه' => $this->teacher->jobBackgrounds?->school,
                'سال شروع' =>  $this->teacher->jobBackgrounds?->start_year,
                'سال پایان' =>  $this->teacher->jobBackgrounds?->end_year
            ],
            'مهارت ها' => [
                SoftSkillForSuggestedResumeResource::collection($this->teacher->skills)
            ],
            'مشاغل درخواستی' => [
                'رشته تحصیلی' => $this->teacher->jobInDemand?->major,
                'شهر' => $this->teacher->jobInDemand?->city,
                'استان' => $this->teacher->jobInDemand?->province,
                'حقوق درخواستی' => $this->teacher->jobInDemand?->salary,
                'مقطع تحصیلی' => $academicLevelForJobInDemand,
                'سمت' => $schoolRoleForJobInDemand,
                'نوع همکاری' =>$typeOfCooperation
            ],
            'معلم برتر' => $this->teacher->isPrime()
        ];
    }
}
