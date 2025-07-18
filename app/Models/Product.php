<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'category_id',
        'description',
        'file',
        'thumbnail',
        'short_description',
        'price',
        'status',
        'slug'
    ];

    public function category()
    {
        return $this->belongsTo(CourseCategory::class);
    }
}
