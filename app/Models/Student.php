<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student';
    protected $primaryKey = 'student_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'user_id',
        'name',
        'matric_no',
        'program_code',
        'intake_year',
        'phone_no',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'student_id', 'student_id');
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class, 'program_code', 'program_code');
    }
}
