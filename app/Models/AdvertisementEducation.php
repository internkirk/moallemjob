<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementEducation extends Model
{
    protected $fillable = [
        'advertisement_id',
        'major',
        'academic_level',
    ];

    public static $columns = [
        'رشته تحصیلی' => 'major',
        'مقطع' => 'academic_level',
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
