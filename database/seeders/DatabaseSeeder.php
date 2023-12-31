<?php

namespace Database\Seeders;

use App\Models\Flag;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::factory()->create([
            'slug' => 'belajarai',
            'name' => 'belajarai',
        ]);

        $misbah = User::factory()->create([
            'name'     => 'Misbah Ansori',
            'email'    => 'misbah.ansori24@gmail.com',
        ]);

        $misbah->flag(Flag::ADMIN);

        $bowo = User::factory()->create([
            'name'     => 'Firdaus Wibowo',
            'email'    => 'bowo@gmail.com'
        ]);

        $bowo->flag(Flag::ADMIN);

        $tenant->users()->attach($misbah);
        $tenant->users()->attach($bowo);
    }
}
