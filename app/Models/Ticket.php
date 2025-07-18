<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
     protected $fillable = [
        'user_id',
        'subject',
        'is_closed'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
     public function content()
    {
        return $this->hasMany(TicketContent::class);
    }
}
