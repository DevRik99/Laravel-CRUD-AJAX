<?php

use App\Usuario;
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
        factory(Usuario::class,2000)->create();
        // $this->call(UserSeeder::class);
    }
}