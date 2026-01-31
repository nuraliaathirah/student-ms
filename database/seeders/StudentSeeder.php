<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get user IDs
        $ahmadUserId = DB::table('users')->where('email', 'ahmad@sms.com')->value('id');
        $umarUserId  = DB::table('users')->where('email', 'umar@sms.com')->value('id');
        $buhairahUserId = DB::table('users')->where('email', 'student@sms.com')->value('id');

        DB::table('student')->insert([
            [
                'student_id' => 'S001',
                'user_id' => $buhairahUserId, // student@sms.com
                'name' => 'Buhairah binti Ahmad',
                'matric_no' => 'A22EC0001',
                'program_code' => 'SECVH',
                'intake_year' => 2022,
                'phone_no' => '0123456789',
            ],
            [
                'student_id' => 'S002',
                'user_id' => $ahmadUserId, // ahmad@sms.com
                'name' => 'Ahmad bin Hassan',
                'matric_no' => 'A22EC0002',
                'program_code' => 'SECVH',
                'intake_year' => 2022,
                'phone_no' => '0123456790',
            ],
            [
                'student_id' => 'S003',
                'user_id' => $umarUserId, // umar@sms.com
                'name' => 'Umar bin Saad',
                'matric_no' => 'A22EC0003',
                'program_code' => 'SECJH',
                'intake_year' => 2022,
                'phone_no' => '0117654321',
            ],
        ]);
    }
}