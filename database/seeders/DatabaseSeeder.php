<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'super@storage.com',
            'level' => 'super-admin',
            'password' => bcrypt('password'),
        ]);

        $this->call(PermissionsSeeder::class);
    }
}
