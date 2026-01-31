<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    protected $table = 'programme';
    protected $primaryKey = 'program_code';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['program_code', 'program_name', 'faculty'];

    public function courses()
    {
        return $this->hasMany(Course::class, 'program_code', 'program_code');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'program_code', 'program_code'); 
    }
}
