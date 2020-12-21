<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');//criando campo que vai armazenar a chave estrangeira
            $table->foreign('user_id')->references('id')->on('users');//indicando a qual campo a chave estrangeira vai se referenciar
            $table->string('user_name');
            $table->string('user_last_name');
            $table->string('cpf')->unique();
            $table->string('num_conta');
            $table->float('saldo')->nullable(); //nullabe para evitar erro
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
        Schema::dropIfExists('contas');
    }
}
