<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::factory()->create([
            'name' => 'test',
        ]);

        $user = User::factory()->create([
            'name'     => 'Misbah Ansori',
            'email'    => 'misbah.ansori24@gmail.com',
        ]);

        $tenant->users()->attach($user);
    }
}
