<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModeratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // make new user with role=2
        \App\Models\User::factory()->create([
            'name' => 'Moderator',
            'email' => 'moderator@example.com',
            'password' => bcrypt('password'),
            'role' => 2,
        ]);

    }
}
