<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('semester')->insert([
            // Past Semesters (Year 1)
            [
                'semester_id' => '2025S1',
                'year' => 2025,
                'session' => 1,
                'is_current' => 0,
                'start_date' => '2025-01-15',
                'end_date' => '2025-05-31',
            ],
            [
                'semester_id' => '2025S2',
                'year' => 2025,
                'session' => 2,
                'is_current' => 0,
                'start_date' => '2025-06-15',
                'end_date' => '2025-12-15',
            ],

            // Current Semester (Year 2 Semester 1)
            [
                'semester_id' => '2026S1',
                'year' => 2026,
                'session' => 1,
                'is_current' => 1,
                'start_date' => '2026-01-15',
                'end_date' => '2026-05-31',
            ],

            // Future Semester (Year 2 Semester 2) - Registration Target
            [
                'semester_id' => '2026S2',
                'year' => 2026,
                'session' => 2,
                'is_current' => 0,
                'start_date' => '2026-06-15',
                'end_date' => '2026-12-15',
            ],
        ]);
    }
}