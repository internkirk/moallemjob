<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SoftSkillForSuggestedResumeResource extends JsonResource
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
            'آیدی' =>$this->id ,
            'عنوان' => $this->title,
            'میزان مهارت' => $this->proficiency,
        ];
    }
}
