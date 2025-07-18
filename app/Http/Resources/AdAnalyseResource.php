<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdAnalyseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'آیدی آگهی' => $this->id,
            'عنوان آگهی' => $this->jobIntroduction?->job_title,
            'رزومه ها' => $this->resumeAdvertisement?->count(),
            'بازدید' => $this->adWatchCount?->count(),
            'استخدام ها' => $this->confirmedResumesCount(),
            'درخواست ها' => $this->receivedResumesCount(),
            // 'مجموع استخدام های نهایی شده' => $this->allConfirmedResumesCount(),
            // 'مجموع رزومه های دریافتی' => $this->allRecivedResumesCount(),
        ];
    }
}
