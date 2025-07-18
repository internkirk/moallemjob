<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementSoftSkill extends Model
{
    protected $fillable = [
        'advertisement_id',
        'skill',
    ];

    public static $columns = [
        'مهارت' => 'skill',
    ];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }


    public static function getColumns()
    {
        return self::$columns;
    }
}
