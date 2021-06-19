<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Create neccessary roles
        Role::create(['name' => 'student']);
        Role::create(['name' => 'teacher']);
        Role::create(['name' => 'schooladmin']);
        $role = Role::create(['name' => 'superadmin']);

        // Create Super Admin Account
        $user = User::factory()->create(
            [
                'name' => 'superadmin',
                'email' => 'superadmin@school.com',
                'password' => Hash::make('superadmin'),
                'email_verified_at' => now()
            ]
        );
        $user->assignRole($role->id);
        
        $this->command->warn('/---------------Admin Account:');
        $this->command->warn($user->email);
        $this->command->warn('Password is "superadmin"');
    }
}