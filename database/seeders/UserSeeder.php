<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@sms.com',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'status' => 'active',
            ],
            [
                'name' => 'Ali',
                'email' => 'ali@sms.com',
                'password' => bcrypt('lecturer123'),
                'role' => 'lecturer',
                'status' => 'active',
            ],
            [
                'name' => 'Buhairah',
                'email' => 'student@sms.com',
                'password' => bcrypt('student123'),
                'role' => 'student',
                'status' => 'active',
            ],
            [
                'name' => 'Ahmad bin Hassan',
                'email' => 'ahmad@sms.com',
                'password' => bcrypt('stud123'),
                'role' => 'student',
                'status' => 'active',
            ],
            [
                'name' => 'Umar bin Saad',
                'email' => 'umar@sms.com',
                'password' => bcrypt('stud123'),
                'role' => 'student',
                'status' => 'active',
            ],
            [
                'name' => 'Prof. Buhairah Abd Ghani',
                'email' => 'buhairah@sms.com',
                'password' => bcrypt('lecturer123'),
                'role' => 'lecturer',
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Ahmad Fauzi',
                'email' => 'ahmadfauzi@sms.com',
                'password' => bcrypt('lecturer123'),
                'role' => 'lecturer',
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Siti Aishah',
                'email' => 'sitiaishah@sms.com',
                'password' => bcrypt('lecturer123'),
                'role' => 'lecturer',
                'status' => 'active',
            ],
            [
                'name' => 'Ir. Mohd Farhan',
                'email' => 'farhan@sms.com',
                'password' => bcrypt('lecturer123'),
                'role' => 'lecturer',
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Nurul Huda',
                'email' => 'nurulhuda@sms.com',
                'password' => bcrypt('lecturer123'),
                'role' => 'lecturer',
                'status' => 'active',
            ],
            [
                'name' => 'Prof. Zulkifli Hassan',
                'email' => 'zulkifli@sms.com',
                'password' => bcrypt('lecturer123'),
                'role' => 'lecturer',
                'status' => 'active',
            ],
            [
                'name' => 'Dr. Aina Sofea',
                'email' => 'ainasofea@sms.com',
                'password' => bcrypt('lecturer123'),
                'role' => 'lecturer',
                'status' => 'active',
            ],  

        ]);
    }
}
