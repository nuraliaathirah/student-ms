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
        $ahmadUserId = DB::table('users')->where('email', 'ahmad@sms.com')->value('id');
        $umarUserId  = DB::table('users')->where('email', 'umar@sms.com')->value('id');

        DB::table('student')->insert([
            [
                'student_id' => 'S001',
                'user_id' => $ahmadUserId,
                'name' => 'Ahmad bin Hassan',
                'matric_no' => 'A24CS567',
                'program_code' => 'SECPH',
                'intake_year' => 2022,
                'phone_no' => '0123456789',
            ],
            [
                'student_id' => 'S002',
                'user_id' => $umarUserId,
                'name' => 'Umar bin Saad',
                'matric_no' => 'A24CS321',
                'program_code' => 'SECVH',
                'intake_year' => 2021,
                'phone_no' => '0117654321',
            ],
        ]);
    }
}
