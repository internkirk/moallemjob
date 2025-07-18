<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'teacher',
        'category_id',
        'description',
        'thumbnail',
        'short_description',
        'price',
        'status',
        'slug'
    ];


    public function episodes()
    {
        return $this->hasMany(CourseEpisode::class);
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class);
    }
}
