<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementJobBackground extends Model
{
    protected $fillable = [
        'advertisement_id',
        'as_intern',
        'must_have_background',
        'background'
    ];

    public static $columns = [
        'جذب به عنوان کارآموز' => 'as_intern',
        'داشتن سابقه کار الزامی است' => 'must_have_background',
        // 'میزان سابقه' => 'background',
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
