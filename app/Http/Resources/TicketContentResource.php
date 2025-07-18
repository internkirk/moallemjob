<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketContentResource extends JsonResource
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
            // 'عنوان' => $this->ticket->subject,
            // 'بسته بودن تیکت' => $this->is_closed ? true : false,
            'آیدی تیکت' => $this->ticket_id,
            'متن' => $this->text,
            'ارسال کننده' => $this->sender,
            'فایل ضمیمه' => $this->file ? $this->file : '#',
        ];
    }
}
