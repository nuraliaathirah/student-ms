<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'registration';
    protected $primaryKey = 'registration_id';
    public $timestamps = false;

    protected $fillable = [
        'registration_id',
        'student_id',
        'section_id',
        'status',
        'registered_at',
        'approved_at',
        'approved_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'section_id', 'section_id');
    }

    public function semester() {
        return $this->belongsTo(Semester::class);
    }

    public function getSemesterAttribute()
    {
        return $this->section->semester ?? null;
    }
    
    public function getCourseAttribute()
    {
        return $this->section->course ?? null;
    }
}
