<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketContent extends Model
{
    protected $fillable = [
        'ticket_id',
        'text',
        'sender',
        'file'
    ];


    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
