<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementJobIntroduction extends Model
{
    protected $fillable = [
        'advertisement_id',
        'job_title',
        'academic_level',
        'school_role',
        'academic_section',
        'major',
        'status',
        'cooperation_type'
    ];

    public static $columns = [
       'عنوان شغل' => 'job_title',
       'مقطع تحصیلی' => 'academic_level',
       'سمت' => 'school_role',
       'پایه تحصیلی' => 'academic_section',
       'رشته' => 'major',
       'نوع همکاری' => 'cooperation_type'
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
