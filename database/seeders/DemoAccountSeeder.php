<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\School;

use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Database\Seeder;

class DemoAccountSeeder extends Seeder
{
    public function run()
    {
        // Create a School
        $school = School::factory()->create(
            [
                'name' => 'Nanyang Technological University'
            ]
        );

        // Create School Admin Account
        $user = User::factory()->create(
            [
                'name' => 'schooladmin',
                'email' => 'schooladmin@school.com',
                'password' => Hash::make('schooladmin'),
                'school_id' => $school->id,
                'email_verified_at' => now()
            ]
        );
        $user->assignRole('schooladmin');
        
        // Create Teacher Account
        $user = User::factory()->create(
            [
                'name' => 'teacher',
                'email' => 'teacher@school.com',
                'password' => Hash::make('teacher'),
                'school_id' => $school->id,
                'email_verified_at' => now()
            ]
        );
        $user->assignRole('teacher');

        // Create Student Account
        $user = User::factory()->create(
            [
                'name' => 'student',
                'email' => 'student@school.com',
                'password' => Hash::make('student'),
                'school_id' => $school->id,
                'email_verified_at' => now()
            ]
        );
        $user->assignRole('student');

        $this->command->warn('/---------------Demo Accounts Created.');

    }
}