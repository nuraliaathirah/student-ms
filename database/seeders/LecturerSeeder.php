<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LecturerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('lecturer')->insert([
            [
                'lecturer_id' => 'L001',
                'user_id' => 2, // Ali
                'name' => 'Dr. Ali bin Abu',
                'staff_no' => 'STF1001',
                'department' => 'Software Engineering',
            ],
            [
                'lecturer_id' => 'L002',
                'user_id' => 6, // Prof. Buhairah Abd Ghani
                'name' => 'Prof. Buhairah Abd Ghani',
                'staff_no' => 'STF1002',
                'department' => 'Data Engineering',
            ],
            [
                'lecturer_id' => 'L003',
                'user_id' => 7, // Dr. Ahmad Fauzi
                'name' => 'Dr. Ahmad Fauzi',
                'staff_no' => 'STF1003',
                'department' => 'Network and Security',
            ],
            [
                'lecturer_id' => 'L004',
                'user_id' => 8, // Dr. Siti Aishah
                'name' => 'Dr. Siti Aishah',
                'staff_no' => 'STF1004',
                'department' => 'Software Engineering',
            ],
            [
                'lecturer_id' => 'L005',
                'user_id' => 9, // Ir. Mohd Farhan
                'name' => 'Ir. Mohd Farhan',
                'staff_no' => 'STF1005',
                'department' => 'Data Engineering',
            ],
            [
                'lecturer_id' => 'L006',
                'user_id' => 10, // Dr. Nurul Huda
                'name' => 'Dr. Nurul Huda',
                'staff_no' => 'STF1006',
                'department' => 'Software Engineering',
            ],
            [
                'lecturer_id' => 'L007',
                'user_id' => 11, // Prof. Zulkifli Hassan
                'name' => 'Prof. Zulkifli Hassan',
                'staff_no' => 'STF1007',
                'department' => 'Network and Security',
            ],
            [
                'lecturer_id' => 'L008',
                'user_id' => 12, // Dr. Aina Sofea
                'name' => 'Dr. Aina Sofea',
                'staff_no' => 'STF1008',
                'department' => 'Data Engineering',
            ],
        ]);
    }
}