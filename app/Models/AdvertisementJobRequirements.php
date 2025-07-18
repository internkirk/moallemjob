<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementJobRequirements extends Model
{
    protected $fillable = [
        'advertisement_id',
        'min_age',
        'max_age',
        'sex'
    ];

    public static $columns = [
        'حداقل سن' => 'min_age',
        'حداکثر سن' => 'max_age',
        'جنسیت' => 'sex',
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
