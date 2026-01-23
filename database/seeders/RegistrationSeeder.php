<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $studentId = 'S002'; 

    
        $prevSection1 = DB::table('course_section')
            ->where('course_id', 'SECR1013') 
            ->where('semester_id', '2026S1')
            ->value('section_id');

        
        $prevSection2 = DB::table('course_section')
            ->where('course_id', 'SECI1143')
            ->where('semester_id', '2026S1')
            ->value('section_id');

        
        $currSection1 = DB::table('course_section')
            ->where('course_id', 'SECP1513')
            ->where('semester_id', '2026S2')
            ->value('section_id');

        
        $currSection2 = DB::table('course_section')
            ->where('course_id', 'SECJ1013')
            ->where('semester_id', '2026S2')
            ->value('section_id');

        // Error checking (Safety net)
        if (!$prevSection1 || !$currSection1) {
            throw new \Exception("Missing course_section records. Please run CourseSectionSeeder first.");
        }

        
        $adminId = DB::table('users')->where('role', 'admin')->value('id') ?? 1;

        
        DB::table('registration')->insert([
           
            [
                'student_id' => $studentId,
                'section_id' => $prevSection1,
                'status' => 'approved',
                'grade' => 'A', 
                'registered_at' => now()->subMonths(6),
                'approved_at' => now()->subMonths(6),
                'approved_by' => $adminId,
            ],
            [
                'student_id' => $studentId,
                'section_id' => $prevSection2, 
                'status' => 'approved',
                'grade' => 'B+', 
                'registered_at' => now()->subMonths(6),
                'approved_at' => now()->subMonths(6),
                'approved_by' => $adminId,
            ],

            [
                'student_id' => $studentId,
                'section_id' => $currSection1, 
                'status' => 'approved',
                'grade' => null, 
                'registered_at' => now(),
                'approved_at' => now(),
                'approved_by' => $adminId,
            ],
            [
                'student_id' => $studentId,
                'section_id' => $currSection2, 
                'status' => 'approved',
                'grade' => null, 
                'registered_at' => now(),
                'approved_at' => now(),
                'approved_by' => $adminId,
            ],
        ]);
    }
}