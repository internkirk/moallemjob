<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrimeAcademyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id" => $this->academy->id,
            "name" => $this->academy->name,
            "phone" => $this->academy->phone,
            "website" => $this->academy->website,
            "students_number" => $this->academy->students_number,
            "province" => $this->academy->province,
            "city" => $this->academy->city,
            "short_description" => $this->academy->short_description,
            "logo" => $this->academy->logo,
            "description" => $this->academy->description,
            "created_at" => $this->academy->created_at,
            "updated_at" => $this->academy->updated_at,
            "اطلاعات تکمیلی" => [
                'سال تاسیس' => $this->academy->academyAdditionalInformation->establishment_year,
                ' تصویر مجوز تاسیس' => $this->academy->academyAdditionalInformation->establishment_license_image,
                'تصویر مجوز راه اندازی' => $this->academy->academyAdditionalInformation->startup_license_image,
                'تصویر نمایه' => $this->academy->academyAdditionalInformation->profile_image,
                'تصاویر مدرسه' => $this->academy->academyAdditionalInformation->school_image,
                'مزایا و تسهیلات سازمانی' => $this->academy->academyAdditionalInformation->benefits
            ],
            "مقاطع تحصیلی" => [
                $this->academy->academyLevel
            ],
            'فرصت های شغلی' => $this->academy->user->advertisements->count(),
            'فرصت های شغلی آموزشگاه' => [
                AdvertisementResource::collection($this->academy->user->advertisements)
            ]
        ];
    }
}
