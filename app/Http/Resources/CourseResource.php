<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'آیدی'=> $this->id,
            'عنوان' => $this->title,
            'دسته بندی' => $this->category->title,
            'مدرس' => $this->teacher,
            'تصویر' => $this->thumbnail,
            'توضیحات' => $this->description,
            'توضیحات کوتاه' => $this->short_description,
            'قیمت' => $this->price,
            // 'وضعیت' => $this->category->title,
            // 'کلمات کلیدی' => $this->category->title,
        ];
    }
}
