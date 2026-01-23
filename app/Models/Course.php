<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';
    protected $primaryKey = 'course_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
        'course_id',
        'course_name',
        'credit_hours',
        'max_students',
        'program_code',
    ];

    public function sections()
    {
        return $this->hasMany(CourseSection::class, 'course_id', 'course_id');
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class, 'program_code', 'program_code');
    }
}
