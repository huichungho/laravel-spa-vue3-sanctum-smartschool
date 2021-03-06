<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(SuperAdminSeeder::class);    //this is the Super Admin seeder
        $this->call(DemoAccountSeeder::class);   //this is the Demo Accounts seeder
    }
}
