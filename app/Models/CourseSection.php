<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    protected $table = 'course_section';
    protected $primaryKey = 'section_id';
    public $timestamps = false;

    protected $fillable = [
        'section_id',
        'course_id',
        'lecturer_id',
        'semester_id',
        'section_no',
        'schedule',
        'venue',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'semester_id');
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class, 'lecturer_id', 'lecturer_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'section_id', 'section_id');
    }
}
