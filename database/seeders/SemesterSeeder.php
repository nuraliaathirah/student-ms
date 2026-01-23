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
            [
                'semester_id' => '2026S1',
                'year' => '2026',
                'session' => 1,
                'start_date' => '2026-01-15',
                'end_date' => '2026-05-15',
            ],
            [
                'semester_id' => '2026S2',
                'year' => '2026',
                'session' => 2,
                'start_date' => '2026-08-01',
                'end_date' => '2026-12-01',
            ],
            [
                'semester_id' => '2025S1',
                'year' => '2025',
                'session' => 1,
                'start_date' => '2025-01-15',
                'end_date' => '2025-05-15',
            ],
            [
                'semester_id' => '2025S2',
                'year' => '2025',
                'session' => 2,
                'start_date' => '2025-08-01',
                'end_date' => '2025-12-01',
            ],
            [
                'semester_id' => '2024S1',
                'year' => '2024',
                'session' => 1,
                'start_date' => '2024-01-15',
                'end_date' => '2024-05-15',
            ],
            [
                'semester_id' => '2024S2',
                'year' => '2024',
                'session' => 2,
                'start_date' => '2024-08-01',
                'end_date' => '2024-12-01',
            ],
        ]);
    }
}
