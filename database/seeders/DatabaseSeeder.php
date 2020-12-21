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
        //chamdando a classe UserSeeder que contem o que vai ser inserido na tabela Users
        $this->call([
          UserSeeder::class,
        ]);
    }
}
