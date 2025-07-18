<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProResumeResource extends JsonResource
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
            'متن' =>$this->text,
            'فایل ضمیمه' =>$this->file,
            'ارسال کننده' =>$this->is_admin ? 'ادمین' : 'کاربر',
        ];
    }
}
