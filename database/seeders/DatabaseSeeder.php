<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\SalarioSeed;
use Database\Seeders\UsuarioSeed;
use Database\Seeders\CategoriaSeed;
use Database\Seeders\UbucacionSeeder;
use Database\Seeders\ExperienciaSeeder;

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
        $this->call(CategoriaSeed::class);
        $this->call(ExperienciaSeeder::class);
        $this->call(UsuarioSeed::class);
        $this->call(UbucacionSeeder::class);
        $this->call(SalarioSeed::class);


    }
}
