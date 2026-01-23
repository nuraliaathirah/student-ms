<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('course')->insert([
            [
                'course_id' => 'SECI1013',
                'course_name' => 'Discrete Structure',
                'credit_hours' => 3,
                'max_students' => 20,
                'program_code' => 'SECPH',
            ],
            [
                'course_id' => 'SECJ1013',
                'course_name' => 'Programming Technique I',
                'credit_hours' => 3,
                'max_students' => 25,
                'program_code' => 'SECPH',
            ],
            [
                'course_id' => 'SECP1513',
                'course_name' => 'Technology and Information System',
                'credit_hours' => 3,
                'max_students' => 30,
                'program_code' => 'SECVH',
            ],
            [
                'course_id' => 'SECR1013',
                'course_name' => 'Digital Logic',
                'credit_hours' => 3,
                'max_students' => 20,
                'program_code' => 'SECVH',
            ],
            [
                'course_id' => 'SECI1143',
                'course_name' => 'Probability and Statistics',
                'credit_hours' => 3,
                'max_students' => 25,
                'program_code' => 'SECRH',
            ],
            [
                'course_id' => 'SECJ2013',
                'course_name' => 'Data Structure and Algorithm',
                'credit_hours' => 3,
                'max_students' => 30,
                'program_code' => 'SECRH',
            ],
            [
                'course_id' => 'SECJ1023',
                'course_name' => 'Programming Technique II',
                'credit_hours' => 3,
                'max_students' => 25,
                'program_code' => 'SECBH',
            ],
            [
                'course_id' => 'SECP2613',
                'course_name' => 'System Analysis and Design',
                'credit_hours' => 3,
                'max_students' => 30,
                'program_code' => 'SECBH',
            ],
            [
                'course_id' => 'SECR1033',
                'course_name' => 'Computer Organization and Architecture',
                'credit_hours' => 3,
                'max_students' => 20,
                'program_code' => 'SECRH',
            ],
            [
                'course_id' => 'SECP2523',
                'course_name' => 'Database',
                'credit_hours' => 3,
                'max_students' => 22,
                'program_code' => 'SECMH',
            ],
            [
                'course_id' => 'SECP3204',
                'course_name' => 'Software Engineering',
                'credit_hours' => 3,
                'max_students' => 25,
                'program_code' => 'SECVH',
            ],
            [
                'course_id' => 'SECP3723',
                'course_name' => 'System Development Technology',
                'credit_hours' => 3,
                'max_students' => 27,
                'program_code' => 'SECMH',
            ],
        ]);
    }
}
