<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSectionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('course_section')->insert([
            // ========== CURRENT SEMESTER (2026S1) ==========
            
            // SECI1013 - Programming Technique I - Multiple Sections
            [
                'section_id' => 1,
                'course_id' => 'SECI1013',
                'lecturer_id' => 'L001', // Dr. Ali
                'semester_id' => '2026S1',
                'section_no' => '01',
                'schedule' => 'Mon 08:00-10:00',
                'venue' => 'N28 MPK5'
            ],
            [
                'section_id' => 2,
                'course_id' => 'SECI1013',
                'lecturer_id' => 'L004', // Dr. Siti Aishah
                'semester_id' => '2026S1',
                'section_no' => '02',
                'schedule' => 'Tue 08:00-10:00',
                'venue' => 'N28 MPK5'
            ],
            
            // SECJ1013 - Object-Oriented Programming
            [
                'section_id' => 3,
                'course_id' => 'SECJ1013',
                'lecturer_id' => 'L002', // Prof. Buhairah
                'semester_id' => '2026S1',
                'section_no' => '01',
                'schedule' => 'Mon 08:00-10:00',
                'venue' => 'N28 MPK9'
            ],
            [
                'section_id' => 4,
                'course_id' => 'SECJ1013',
                'lecturer_id' => 'L006', // Dr. Nurul Huda
                'semester_id' => '2026S1',
                'section_no' => '02',
                'schedule' => 'Thu 14:00-16:00',
                'venue' => 'N28 MPK7'
            ],
            
            // SECP1513 - Technology and Information Systems
            [
                'section_id' => 5,
                'course_id' => 'SECP1513',
                'lecturer_id' => 'L001', // Dr. Ali
                'semester_id' => '2026S1',
                'section_no' => '01',
                'schedule' => 'Wed 10:00-13:00',
                'venue' => 'N28 BK1'
            ],
            
            // SECR1013 - Digital Logic
            [
                'section_id' => 6,
                'course_id' => 'SECR1013',
                'lecturer_id' => 'L007', // Prof. Zulkifli
                'semester_id' => '2026S1',
                'section_no' => '01',
                'schedule' => 'Tue 10:00-13:00',
                'venue' => 'N28 Lab1'
            ],
            [
                'section_id' => 7,
                'course_id' => 'SECR1013',
                'lecturer_id' => 'L003', // Dr. Ahmad Fauzi
                'semester_id' => '2026S1',
                'section_no' => '02',
                'schedule' => 'Thu 10:00-13:00',
                'venue' => 'N28 Lab2'
            ],
            
            // SECI1143 - Computer Organization and Architecture
            [
                'section_id' => 8,
                'course_id' => 'SECI1143',
                'lecturer_id' => 'L006', // Dr. Nurul Huda
                'semester_id' => '2026S1',
                'section_no' => '01',
                'schedule' => 'Wed 14:00-17:00',
                'venue' => 'N28 BK2'
            ],
            
            // SECJ2013 - Data Structures and Algorithms
            [
                'section_id' => 9,
                'course_id' => 'SECJ2013',
                'lecturer_id' => 'L002', // Prof. Buhairah
                'semester_id' => '2026S1',
                'section_no' => '01',
                'schedule' => 'Fri 08:00-11:00',
                'venue' => 'N28 MPK6'
            ],
            [
                'section_id' => 10,
                'course_id' => 'SECJ2013',
                'lecturer_id' => 'L005', // Ir. Mohd Farhan
                'semester_id' => '2026S1',
                'section_no' => '02',
                'schedule' => 'Fri 14:00-17:00',
                'venue' => 'N28 MPK8'
            ],

            // ========== PAST SEMESTER (2025S2) ==========
            
            [
                'section_id' => 100,
                'course_id' => 'SECR1013',
                'lecturer_id' => 'L008', // Dr. Aina Sofea
                'semester_id' => '2025S2',
                'section_no' => '01',
                'schedule' => 'Sun 10:00-13:00',
                'venue' => 'N28 Lab'
            ],
            [
                'section_id' => 101,
                'course_id' => 'SECI1143',
                'lecturer_id' => 'L006', // Dr. Nurul Huda
                'semester_id' => '2025S2',
                'section_no' => '01',
                'schedule' => 'Tue 10:00-13:00',
                'venue' => 'N28 BK2'
            ],
            [
                'section_id' => 102,
                'course_id' => 'SECI1013',
                'lecturer_id' => 'L001', // Dr. Ali
                'semester_id' => '2025S2',
                'section_no' => '01',
                'schedule' => 'Mon 08:00-10:00',
                'venue' => 'N28 MPK5'
            ],
            [
                'section_id' => 103,
                'course_id' => 'SECJ1013',
                'lecturer_id' => 'L002', // Prof. Buhairah
                'semester_id' => '2025S2',
                'section_no' => '01',
                'schedule' => 'Wed 10:00-12:00',
                'venue' => 'N28 MPK9'
            ],

            // ========== PAST SEMESTER (2025S1) ==========
            
            [
                'section_id' => 200,
                'course_id' => 'SECI1013',
                'lecturer_id' => 'L004', // Dr. Siti Aishah
                'semester_id' => '2025S1',
                'section_no' => '01',
                'schedule' => 'Tue 08:00-10:00',
                'venue' => 'N28 MPK5'
            ],
            [
                'section_id' => 201,
                'course_id' => 'SECJ1013',
                'lecturer_id' => 'L002', // Prof. Buhairah
                'semester_id' => '2025S1',
                'section_no' => '01',
                'schedule' => 'Wed 10:00-12:00',
                'venue' => 'N28 MPK9'
            ],
            [
                'section_id' => 202,
                'course_id' => 'SECP1513',
                'lecturer_id' => 'L001', // Dr. Ali
                'semester_id' => '2025S1',
                'section_no' => '01',
                'schedule' => 'Thu 10:00-13:00',
                'venue' => 'N28 BK1'
            ],
        ]);
    }
}