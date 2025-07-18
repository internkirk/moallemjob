<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'آیدی کاربر' => $this->user_id,
            'موضوع' => $this->subject,
            'بسته بودن تیکت' => $this->is_closed ? true : false,
            'پیش نمایش متن' =>  $this->content->first()->text
        ];
    }
}
