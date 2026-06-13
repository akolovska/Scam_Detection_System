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
        $this->call([
            ScamCategorySeeder::class,
        ]);
        ScamReport::factory(25)->create();

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
    }
}
