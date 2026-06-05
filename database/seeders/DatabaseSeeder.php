<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $studentRole = Role::where('name', 'Student')->first();
        $adminRole = Role::where('name', 'Admin')->first();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role_id' => $studentRole?->id,
        ]);

        User::factory()->create([
            'name' => 'Admin Nexora',
            'email' => 'admin@nexora.id',
            'role_id' => $adminRole?->id,
        ]);
    }
}
