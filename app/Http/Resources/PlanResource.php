<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'آیدی' => $this->id,
            'عنوان' => $this->title,
            'وضعیت' => $this->status ? true : false,
            'قیمت' => $this->price,
            'انقضا درج آگهی' => $this->declaration_expire_days,
            'تعداد ارسال آگهی استخدام' => $this->recruitment_declaration_quantity,
            'تعداد شغل های برجسته' => $this->outstanding_job_quantity,
            'اطلاع رسانی تلگرام' => $this->telegram_declaration ? true : false,
            'اطلاع رسانی ایمیلی' => $this->email_declaration ? true : false,
            'اطلاع رسانی پیامکی' => $this->sms_declaration ? true : false,
            'تعداد رزومه پیشنهادی' => $this->suggested_resume_quantity,
            'پشتیبانی تمام وقت' => $this->is_full_time_support ? true : false,
            'نمایش متمایز آگهی و درج برچسب فوری' => $this->is_suggested_resume ? true : false,
            'یک و نیم برابر نمایش بیشتر در نتایج جستجو' => $this->is_one_and_half_possibility_in_search_results ? true : false,
            'دو برابر نمایش بیشتر در نتایج جستجو' => $this->is_two_possibility_in_search_results ? true : false,
            'یک و نیم برابر بازدید بیشتر توسط کارجویان هدف' => $this->is_one_and_half_possibility_to_visit_by_job_seekers ? true : false,
            'دو برابر بازدید بیشتر توسط کارجویان هدف' => $this->is_two_possibility_to_visit_by_job_seekers ? true : false,
            'مشاهده آمار و تحلیل های مربوط به آگهی ها' => $this->show_declaration_analytics ? true : false,
            'دسترسی به لیست معلم های برتر' => $this->access_to_best_teachers_list ? true : false,
            'طراحی پلن متناسب با نیاز های خاص کارفرما' => $this->design_specific_plan ? true : false,
            'مشاوره تخصصی در زمینه جذب معلم' => $this->specialized_advice ? true : false,
            'اضافه کردن ویژگی های خاص براساس درخواست' => $this->adding_specific_features ? true : false,
            'مشاوره نوشتن آگهی استخدام' => $this->recruitment_declaration_advice ? true : false,
            'پشتیبانی اختصاصی تا لحظه استخدام' => $this->recruitment_specific_support ? true : false,
            'کمک به غربال گری رزومه های دریافتی' => $this->screening_resume_support ? true : false,
             'پیشنهادی' => $this->is_suggested ? true : false,
             'روز های باقی مانده' => $this->userPlan->first()?->remainingDays()
        ];
    }
}
