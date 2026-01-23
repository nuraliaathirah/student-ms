<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProgrammeSeeder::class,    
            UserSeeder::class,         
            StudentSeeder::class,      
            LecturerSeeder::class,     
            SemesterSeeder::class,     
            CourseSeeder::class,       
            CourseSectionSeeder::class,
            RegistrationSeeder::class, 
        ]);
    }
}
