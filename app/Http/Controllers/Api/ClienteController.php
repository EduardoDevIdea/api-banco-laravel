<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
        
        return response()->json($clientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cliente = new Cliente;

        $cliente->nome = $request->nome;
        $cliente->sobrenome = $request->sobrenome;
        $cliente->cpf = $request->cpf;
        $cliente->telefone_1 = $request->telefone_1;
        $cliente->telefone_2 = $request->telefone_2;
        $cliente->cep = $request->cep;
        $cliente->logradouro = $request->logradouro;
        $cliente->complemento = $request->complemento;
        $cliente->bairro = $request->bairro;
        $cliente->municipio = $request->municipio;
        $cliente->estado = $request->estado;
        $cliente->senha = null; // a senha vai ser armazenada na tabela user, pois ela está envolvida na lógica de autenticação do cliente
        $cliente->saldo = $request->saldo;
        $cliente->num_conta = rand(); //rand() gera numero aleatorio (consultar documentacao php)
        

        $cliente->save();

        // Criando o registro de usuário com informações vindas da tela de cadastro de cliente
        // O novo usuário poderá acessar sua conta através de um login com cpf e senha
        $user = new User;
        $user->name = $request->nome;
        $user->sobrenome = $request->sobrenome;
        $user->cpf = $request->cpf;
        $user->email = null; // email nulo, por enquanto, pois veio como padrão na migration da tabela users. Será modificado quando necessário 
        $user->tipo = "cliente"; //usuário sinalizado como "cliente", pois foi cadastrado com o formulario de cadastro de cliente
        $user->password = Hash::make($request->senha);
        $user->save();

        return response()->json($cliente);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$cliente = Cliente::where('id', $id)->first();
        $cliente = Cliente::find($id);

        return response()->json($cliente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        $cliente->nome = $request->nome;
        $cliente->sobrenome = $request->sobrenome;
        $cliente->cpf = $request->cpf;
        $cliente->telefone_1 = $request->telefone_1;
        $cliente->telefone_2 = $request->telefone_2;
        $cliente->cep = $request->cep;
        $cliente->logradouro = $request->logradouro;
        $cliente->complemento = $request->complemento;
        $cliente->bairro = $request->bairro;
        $cliente->municipio = $request->municipio;
        $cliente->estado = $request->estado;

        $cliente->save();

        return response()->json($cliente);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
