<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $registrations = [];

        // ========== STUDENT S001 (Buhairah) ==========
        // Past Semester 2025S1 - with grades
        $registrations[] = [
            'student_id' => 'S001',
            'section_id' => 200, // SECI1013 - 2025S1 - Dr. Siti Aishah
            'status' => 'approved',
            'grade' => 'A',
            'registered_at' => '2025-01-15'
        ];
        $registrations[] = [
            'student_id' => 'S001',
            'section_id' => 201, // SECJ1013 - 2025S1 - Prof. Buhairah
            'status' => 'approved',
            'grade' => 'A-',
            'registered_at' => '2025-01-15'
        ];
        
        // Past Semester 2025S2 - with grades
        $registrations[] = [
            'student_id' => 'S001',
            'section_id' => 102, // SECI1013 - 2025S2 - Dr. Ali
            'status' => 'approved',
            'grade' => 'B+',
            'registered_at' => '2025-08-15'
        ];
        $registrations[] = [
            'student_id' => 'S001',
            'section_id' => 100, // SECR1013 - 2025S2 - Dr. Aina
            'status' => 'approved',
            'grade' => 'A-',
            'registered_at' => '2025-08-15'
        ];
        
        // Current Semester 2026S1 - no grades
        $registrations[] = [
            'student_id' => 'S001',
            'section_id' => 1, // SECI1013 Section 01 - Dr. Ali
            'status' => 'approved',
            'grade' => null,
            'registered_at' => '2026-01-10'
        ];
        $registrations[] = [
            'student_id' => 'S001',
            'section_id' => 5, // SECP1513 - Dr. Ali
            'status' => 'approved',
            'grade' => null,
            'registered_at' => '2026-01-10'
        ];
        $registrations[] = [
            'student_id' => 'S001',
            'section_id' => 9, // SECJ2013 - Prof. Buhairah
            'status' => 'approved',
            'grade' => null,
            'registered_at' => '2026-01-10'
        ];

        // ========== STUDENT S002 (Ahmad bin Hassan) ==========
        // Past Semester 2025S2 - with grades
        $registrations[] = [
            'student_id' => 'S002',
            'section_id' => 100, // SECR1013 - 2025S2
            'status' => 'approved',
            'grade' => 'A-',
            'registered_at' => '2025-08-15'
        ];
        $registrations[] = [
            'student_id' => 'S002',
            'section_id' => 101, // SECI1143 - 2025S2
            'status' => 'approved',
            'grade' => 'B+',
            'registered_at' => '2025-08-20'
        ];
        $registrations[] = [
            'student_id' => 'S002',
            'section_id' => 103, // SECJ1013 - 2025S2
            'status' => 'approved',
            'grade' => 'A',
            'registered_at' => '2025-08-20'
        ];
        
        // Current Semester 2026S1 - no grades
        $registrations[] = [
            'student_id' => 'S002',
            'section_id' => 1, // SECI1013 Section 01 - Dr. Ali
            'status' => 'approved',
            'grade' => null,
            'registered_at' => '2026-01-10'
        ];
        $registrations[] = [
            'student_id' => 'S002',
            'section_id' => 5, // SECP1513 - Dr. Ali
            'status' => 'approved',
            'grade' => null,
            'registered_at' => '2026-01-10'
        ];
        $registrations[] = [
            'student_id' => 'S002',
            'section_id' => 6, // SECR1013 - Prof. Zulkifli
            'status' => 'approved',
            'grade' => null,
            'registered_at' => '2026-01-10'
        ];

        // ========== STUDENT S003 (Umar bin Saad) ==========
        // Past Semester 2025S1 - with grades
        $registrations[] = [
            'student_id' => 'S003',
            'section_id' => 200, // SECI1013 - 2025S1
            'status' => 'approved',
            'grade' => 'B+',
            'registered_at' => '2025-01-15'
        ];
        $registrations[] = [
            'student_id' => 'S003',
            'section_id' => 202, // SECP1513 - 2025S1
            'status' => 'approved',
            'grade' => 'B',
            'registered_at' => '2025-01-15'
        ];
        
        // Current Semester 2026S1 - no grades
        $registrations[] = [
            'student_id' => 'S003',
            'section_id' => 2, // SECI1013 Section 02 - Dr. Siti Aishah
            'status' => 'approved',
            'grade' => null,
            'registered_at' => '2026-01-10'
        ];
        $registrations[] = [
            'student_id' => 'S003',
            'section_id' => 3, // SECJ1013 Section 01 - Prof. Buhairah
            'status' => 'approved',
            'grade' => null,
            'registered_at' => '2026-01-10'
        ];
        $registrations[] = [
            'student_id' => 'S003',
            'section_id' => 7, // SECR1013 Section 02 - Dr. Ahmad Fauzi
            'status' => 'approved',
            'grade' => null,
            'registered_at' => '2026-01-10'
        ];
        $registrations[] = [
            'student_id' => 'S003',
            'section_id' => 10, // SECJ2013 Section 02 - Ir. Farhan
            'status' => 'approved',
            'grade' => null,
            'registered_at' => '2026-01-10'
        ];

        DB::table('registration')->insert($registrations);
    }
}