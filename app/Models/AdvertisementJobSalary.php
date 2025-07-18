<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementJobSalary extends Model
{
    protected $fillable = [
        'advertisement_id',
        'min_salary',
        'max_salary',
        'benefits'
    ];

    public static $columns = [
        'حداقل حقوق' => 'min_salary',
        'حداکثر حقوق' => 'max_salary',
        // 'مزایا و تسهیلات' => 'benefits',
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
