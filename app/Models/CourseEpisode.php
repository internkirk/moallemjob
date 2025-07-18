<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseEpisode extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'thumbnail',
        'short_description',
        'duration',
        'link',
        'status',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
