<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProResumeRequestsResource extends JsonResource
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
            'عنوان' =>'درخواست رزومه حرفه ای',
            'آیدی' => $this->id,
            'کاربر' => $this->teacher->first_name . " " . $this->teacher->last_name,
            'وضعیت درخواست' => $this->request_stage
        ];
    }
}
