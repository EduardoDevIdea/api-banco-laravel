<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'last_name' => 'admin',
            'tipo' => 'admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('admin'),
            'cpf' => 'cpf-admin',
            'telefone_1' => 'Tel_1-admin', 
            'telefone_2' => 'Tel_2-admin',
            'cep' => 'cep-admin',
            'logradouro' => 'logradouro-admin',
            'complemento' => 'complemento-admin',
            'bairro' => 'bairro-admin',
            'municipio' => 'municipio-admin',
            'estado'=> 'estado-admin',
        ]);
    }
}
