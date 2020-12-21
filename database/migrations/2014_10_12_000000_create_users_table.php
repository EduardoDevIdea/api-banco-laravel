<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('tipo');
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->string('cpf')->unique();
            $table->string('telefone_1');
            $table->string('telefone_2')->nullable();
            $table->string('cep');
            $table->text('logradouro');
            $table->text('complemento')->nullable();
            $table->string('bairro');
            $table->string('municipio');
            $table->string('estado');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
