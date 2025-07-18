<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcademyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "name" => $this->name,
            "phone" => $this->phone,
            "website" => $this->website,
            "students_number" => $this->students_number,
            "province" => $this->province,
            "city" => $this->city,
            "short_description" => $this->short_description,
            "logo" => $this->logo,
            "description" => $this->description,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "ایمیل" => $this->email,
            "اطلاعات تکمیلی" => [
                'سال تاسیس' => $this->academyAdditionalInformation?->establishment_year,
                ' تصویر مجوز تاسیس' => $this->academyAdditionalInformation?->establishment_license_image,
                'تصویر مجوز راه اندازی' => $this->academyAdditionalInformation?->startup_license_image,
                'تصویر نمایه' => $this->academyAdditionalInformation?->profile_image,
                'تصاویر مدرسه' => $this->academyAdditionalInformation?->school_image,
                'مزایا و تسهیلات سازمانی' => $this->academyAdditionalInformation?->benefits
            ],
            "مقاطع تحصیلی" => [
                $this->academyLevel
            ],
            'آموزشگاه برتر' => $this->isPrime(),
            'فرصت های شغلی' => $this->user->advertisements->count(),
            'فرصت های شغلی آموزشگاه' => [
                AdvertisementResource::collection($this->user->advertisements)
            ]
        ];
    }
}
