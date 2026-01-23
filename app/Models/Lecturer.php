<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $table = 'lecturer';
    protected $primaryKey = 'lecturer_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
        'lecturer_id',
        'user_id',
        'name',
        'staff_no',
        'department',
    ];

    public function sections()
    {
        return $this->hasMany(CourseSection::class, 'lecturer_id', 'lecturer_id');
    }
}
