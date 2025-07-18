<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementJobDescription extends Model
{
    protected $fillable = [
        'advertisement_id',
        'job_time',
        'job_description'
    ];

    public static $columns = [
        'ساعت و روز کاری' => 'job_time',
        // 'داشتن سابقه کار الزامی است' => 'job_description',
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
