<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementAdditionalCondition extends Model
{
    protected $fillable = [
        'advertisement_id',
        'military_service',
        'selection_certificate',
        'no_crime_certificate'
    ];

    public static $columns = [
        // 'اتمام خدمت سربازی یا معافیت' => 'military_service',
        'گواهی گزینش' => 'selection_certificate',
        // 'گواهی عدم سوء پیشینه' => 'no_crime_certificate',
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
