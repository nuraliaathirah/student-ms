<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lecturer')->insert([
            [
                'lecturer_id' => 'L001',
                'user_id' => 2,
                'name' => 'Dr. Ali bin Abu',
                'staff_no' => 'STF1001',
                'department' => 'Computer Science',
            ],
            [
                'lecturer_id' => 'L002',
                'user_id' => 6,
                'name' => 'Prof. Buhairah Abd Ghani',
                'staff_no' => 'STF1002',
                'department' => 'Graphic Design',
            ],
            [
                'lecturer_id' => 'L003',
                'user_id' => 7,
                'name' => 'Dr. Ahmad Fauzi',
                'staff_no' => 'STF1003',
                'department' => 'Network and Security',
            ],
            [
                'lecturer_id' => 'L004',
                'user_id' => 8,
                'name' => 'Dr. Siti Aishah',
                'staff_no' => 'STF1004',
                'department' => 'Software Engineering',
            ],
            [
                'lecturer_id' => 'L005',
                'user_id' => 9,
                'name' => 'Ir. Mohd Farhan',
                'staff_no' => 'STF1005',
                'department' => 'Data Engineering',
            ],
            [
                'lecturer_id' => 'L006',
                'user_id' => 10,
                'name' => 'Dr. Nurul Huda',
                'staff_no' => 'STF1006',
                'department' => 'Information Systems',
            ],
            [
                'lecturer_id' => 'L007',
                'user_id' => 11,
                'name' => 'Prof. Zulkifli Hassan',
                'staff_no' => 'STF1007',
                'department' => 'Artificial Intelligence',
            ],
            [
                'lecturer_id' => 'L008',
                'user_id' => 12,
                'name' => 'Dr. Aina Sofea',
                'staff_no' => 'STF1008',
                'department' => 'Cyber Security',
            ],
        ]);
    }
}
