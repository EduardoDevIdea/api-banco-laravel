<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; 

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//-----LOGIN--------------------------------------------------------------------------------------

Route::post('/login', 'App\Http\Controllers\Api\AuthController@login'); //Auth controller valida user com Token JWT, caso senha e cpf estejam corretos
//------------------------------------------------------------------------------------------------

//---------Rotas protegidas pelo Middleware ApiJWT-------------------------------------------------

Route::group(['middleware' => ['ApiJWT']], function(){

    //-----lOGOUT - invalida o token
    Route::post('/logout', 'App\Http\Controllers\Api\AuthController@logout');

    //-----AUTHENTICATED USER - retorna o usuário autenticado
    Route::post('/auth-user', 'App\Http\Controllers\Api\AuthController@me');

    //-----USER---------------------------------------------------------------------------------------
    //Cadastra user do tipo cliente e cria uma conta para ele
    Route::post('/cadastro-cliente', 'App\Http\Controllers\Api\UserController@cadastroCliente');

    //Cadastra user tipo admin
    Route::post('/cadastro-admin', 'App\Http\Controllers\Api\UserController@cadastroAdmin');

    //Busca user do tipo cliente usando a chave estrangeira user_id ta tabela contas
    Route::get('/show-cliente/{id}', 'App\Http\Controllers\Api\UserController@showCliente');

    //Atualiza dados do user do topo cliente
    Route::post('/update-cliente/{id}', 'App\Http\Controllers\Api\UserController@updateCliente');

    //Altera Senha do user
    Route::post('/change-password', 'App\Http\Controllers\Api\UserController@changePassword');
    //------------------------------------------------------------------------------------------------

    //-----CONTA--------------------------------------------------------------------------------------
    //Busca todas as contas cadastradas
    Route::get('/contas', 'App\Http\Controllers\Api\ContaController@index');

    //Busca uma conta específica
    Route::get('/show-conta/{cpf}', 'App\Http\Controllers\Api\ContaController@show');
    //--------------------------------------------------------------------------------------------------

    //-----OPERACOES------------------------------------------------------------------------------------
    //Saque
    Route::post('/saque', 'App\Http\Controllers\Api\Operacoes@saque');

    //Transferencia
    Route::post('/transferencia', 'App\Http\Controllers\Api\Operacoes@transferencia');

    //Depósito
    Route::post('/deposito', 'App\Http\Controllers\Api\Operacoes@deposito');
    //--------------------------------------------------------------------------------------------------

});
//------------------------------------------------------------------------------------------------------


//Route::post('/update/{id}', 'App\http\Controllers\Api\ClienteController@update');

//Route::get('/saldo/{id}', 'Api\ContaCorrenteController@saldo');
