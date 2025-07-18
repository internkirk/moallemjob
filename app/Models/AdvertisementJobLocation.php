<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementJobLocation extends Model
{
    protected $fillable = [
        'advertisement_id',
        'province',
        'city'
    ];

    public static $columns = [
        'استان' => 'province',
        'شهر' => 'city',
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
