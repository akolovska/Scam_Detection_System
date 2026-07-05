<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\ScamReport;
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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => UserRole::ADMIN,
        ]);
        User::factory()->create([
            'name' => 'Alice Johnson',
            'email' => 'alice@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'John Smith',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Emily Davis',
            'email' => 'emily@example.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Michael Brown',
            'email' => 'michael@example.com',
            'password' => bcrypt('password'),
        ]);
        User::factory()->create([
            'name' => 'Admin2',
            'email' => 'admin2@example.com',
            'password' => bcrypt('password'),
            'role' => UserRole::ADMIN,
        ]);
        User::factory()->create([
            'name' => 'Admin3',
            'email' => 'admin3@example.com',
            'password' => bcrypt('password'),
            'role' => UserRole::ADMIN,
        ]);
        User::factory()->create([
            'name' => 'Admin4',
            'email' => 'admin4@example.com',
            'password' => bcrypt('password'),
            'role' => UserRole::ADMIN,
        ]);
        User::factory()->create([
            'name' => 'Admin5',
            'email' => 'admin5@example.com',
            'password' => bcrypt('password'),
            'role' => UserRole::ADMIN,
        ]);
        User::factory()->create([
            'name' => 'Ana',
            'email' => 'kolovskaana8@gmail.com',
            'password' => bcrypt('ana'),
            'role' => UserRole::ADMIN,
        ]);

        $this->call([
            ScamCategorySeeder::class,
            ScamReportSeeder::class,
        ]);
    }
}
