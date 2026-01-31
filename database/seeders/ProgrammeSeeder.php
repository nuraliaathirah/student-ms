<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgrammeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('programme')->insert([
            [
                'program_code' => 'SECRH',
                'program_name' => 'Network and Security',
                'faculty' => 'Faculty of Computing',
            ],
            [
                'program_code' => 'SECPH',
                'program_name' => 'Data Engineering',
                'faculty' => 'Faculty of Computing',
            ],
            [
                'program_code' => 'SECVH',
                'program_name' => 'Software Engineering',
                'faculty' => 'Faculty of Computing',
            ],
            [
                'program_code' => 'SECJH',
                'program_name' => 'Software Engineering with Honours',
                'faculty' => 'Faculty of Computing',
            ],
            [
                'program_code' => 'SECBH',
                'program_name' => 'Bioinformatics',
                'faculty' => 'Faculty of Computing',
            ],
            [
                'program_code' => 'SECMH',
                'program_name' => 'Graphic and Multimedia',
                'faculty' => 'Faculty of Computing',
            ],
        ]);
    }
}