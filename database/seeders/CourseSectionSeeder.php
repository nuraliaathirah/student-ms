<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('course_section')->insert([
            [
                'section_id' => 1,
                'course_id' => 'SECI1013',
                'lecturer_id' => 'L001',
                'semester_id' => '2026S2',
                'section_no' => '01', 
                'schedule' => 'Mon-Wed 10:00-11:30',
                'venue' => 'N28 MPK5',
            ],
            [
                'section_id' => 2,
                'course_id' => 'SECJ1013',
                'lecturer_id' => 'L002',
                'semester_id' => '2026S2',
                'section_no' => '01', 
                'schedule' => 'Tue-Thu 14:00-15:30',
                'venue' => 'N28 MPK9',
            ],
            [
                'section_id' => 3,
                'course_id' => 'SECP1513',
                'lecturer_id' => 'L001',
                'semester_id' => '2026S2',
                'section_no' => '01', 
                'schedule' => 'Mon-Wed 12:00-13:30',
                'venue' => 'N28 MPK7',
            ],
            [
                'section_id' => 4,
                'course_id' => 'SECR1013',
                'lecturer_id' => 'L002',
                'semester_id' => '2026S1',
                'section_no' => '01', 
                'schedule' => 'Tue-Thu 10:00-11:30',
                'venue' => 'N28 CCNA Lab',
            ],
            [
                'section_id' => 5,
                'course_id' => 'SECI1143',
                'lecturer_id' => 'L001',
                'semester_id' => '2026S1',
                'section_no' => '01', 
                'schedule' => 'Mon-Wed 14:00-15:30',
                'venue' => 'N28 BK1',
            ],
            [
                'section_id' => 6,
                'course_id' => 'SECJ2013',
                'lecturer_id' => 'L002',
                'semester_id' => '2026S2',
                'section_no' => '01', 
                'schedule' => 'Fri 09:00-12:00',
                'venue' => 'N28 BK7',
            ],
            [
                'section_id' => 7,
                'course_id' => 'SECJ1023',
                'lecturer_id' => 'L001',
                'semester_id' => '2026S1',
                'section_no' => '01', 
                'schedule' => 'Tue-Thu 12:00-13:30',
                'venue' => 'N28 MPK6',
            ],
            [
                'section_id' => 8,
                'course_id' => 'SECP2613',
                'lecturer_id' => 'L002',
                'semester_id' => '2026S2',
                'section_no' => '01', 
                'schedule' => 'Mon-Wed 16:00-17:30',
                'venue' => 'N28 BK3',
            ],
            [
                'section_id' => 9,
                'course_id' => 'SECR1033',
                'lecturer_id' => 'L001',
                'semester_id' => '2026S2',
                'section_no' => '01', 
                'schedule' => 'Fri 13:00-16:00',
                'venue' => 'N28 CCNA Lab',
            ],
            [
                'section_id' => 10,
                'course_id' => 'SECI1013',
                'lecturer_id' => 'L004',
                'semester_id' => '2026S2',
                'section_no' => '02', 
                'schedule' => 'Mon-Wed 10:00-11:30',
                'venue' => 'N28 MPK5',
            ],
            [
                'section_id' => 11,
                'course_id' => 'SECJ1013',
                'lecturer_id' => 'L007',
                'semester_id' => '2026S2',
                'section_no' => '02', 
                'schedule' => 'Tue-Thu 14:00-15:30',
                'venue' => 'N28 MPK9',
            ],
            [
                'section_id' => 12,
                'course_id' => 'SECP1513',
                'lecturer_id' => 'L005',
                'semester_id' => '2026S2',
                'section_no' => '02', 
                'schedule' => 'Mon-Wed 12:00-13:30',
                'venue' => 'N28 MPK7',
            ],
            [
                'section_id' => 13,
                'course_id' => 'SECR1013',
                'lecturer_id' => 'L008',
                'semester_id' => '2026S2',
                'section_no' => '02', 
                'schedule' => 'Tue-Thu 10:00-11:30',
                'venue' => 'N28 CCNA Lab',
            ],
            [
                'section_id' => 14,
                'course_id' => 'SECI1143',
                'lecturer_id' => 'L006',
                'semester_id' => '2026S1',
                'section_no' => '02', 
                'schedule' => 'Mon-Wed 14:00-15:30',
                'venue' => 'N28 BK1',
            ],
            [
                'section_id' => 15,
                'course_id' => 'SECJ2013',
                'lecturer_id' => 'L003',
                'semester_id' => '2026S2',
                'section_no' => '02', 
                'schedule' => 'Fri 09:00-12:00',
                'venue' => 'N28 BK7',
            ],
            [
                'section_id' => 16,
                'course_id' => 'SECJ1023',
                'lecturer_id' => 'L004',
                'semester_id' => '2026S1',
                'section_no' => '02', 
                'schedule' => 'Tue-Thu 12:00-13:30',
                'venue' => 'N28 MPK6',
            ],
            [
                'section_id' => 17,
                'course_id' => 'SECP2613',
                'lecturer_id' => 'L005',
                'semester_id' => '2026S2',
                'section_no' => '02', 
                'schedule' => 'Mon-Wed 16:00-17:30',
                'venue' => 'N28 BK3',
            ],
            [
                'section_id' => 18,
                'course_id' => 'SECR1033',
                'lecturer_id' => 'L008',
                'semester_id' => '2026S1',
                'section_no' => '02', 
                'schedule' => 'Fri 13:00-16:00',
                'venue' => 'N28 CCNA Lab',
            ],
        ]);
    }
}
