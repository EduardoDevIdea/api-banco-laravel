<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Conta;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Cadastra usuário do tipo cliente
     * Em seguida, cria conta corrente para o cliente, após criar cadastro de usuário
     */
    public function cadastroCliente (Request $request){

        $userCliente = new User;

        //Atribuindo dados do usuário vindos do formulário de cadastro
        $userCliente->name = $request->name;
        $userCliente->last_name = $request->last_name;
        $userCliente->cpf = $request->cpf;
        $userCliente->telefone_1 = $request->telefone_1;
        $userCliente->telefone_2 = $request->telefone_2;
        $userCliente->email = $request->email;
        $userCliente->cep = $request->cep;
        $userCliente->logradouro = $request->logradouro;
        $userCliente->complemento = $request->complemento;
        $userCliente->bairro = $request->bairro;
        $userCliente->municipio = $request->municipio;
        $userCliente->estado = $request->estado;

        //password do usuário recebe senha cripitografada
        $userCliente->password = Hash::make($request->password);

        //Atribuindo usuario como cliente
        $userCliente->tipo = "cliente";

        //Salvando registro de usuário do tipo cliente
        $userCliente->save();

        //------------CRIAÇÂO DE CONTA PARA O USER CLIENTE---------------------
        //Criando Conta corrente para o usuario que acabou de ser cadastrado
        $conta = new Conta;

        $conta->user_name = $request->name;
        $conta->user_last_name = $request->last_name;
        $conta->cpf = $request->cpf;

        //Pegando o id do user para armazenar na user_id (chave estrangeira da tabela conta)
        $user_id = User::where('cpf', $request->cpf)->value('id'); //pegando apenas o id onde o cpf é igual ao fornecido na requisição
        $conta->user_id = $user_id;

        //Atribuição do numero da conta
        $num_default = '111'; //numero escolhido para ser contatenado com todos os numeros de contas (foi escolhido o tipo string para poder concatenar)
        $num_random = rand(); //gerando numero aleatório utilizando método rand() do php (consultar documentação do php)
        $num_conta = $num_default.$num_random; //concatenando os numeros criados acima
        $conta->num_conta = $num_conta;

        //Armazenando conta recém criada como null (regra do negócio para uma conta recém criada)
        $conta->saldo = null;

        //Salvando todos os dados da nova conta no banco de dados
        $conta->save();

        //ao final da criação do user e da conta corrente do user, retorna o usuário criado
        return response()->json($conta);
    }


    /**
     * Busca o usuário do tipo cliente
     */
    public function showCliente($id){
        $userCliente = User::find($id); //está retornando a conta e não o usuário (corrigir isso)

        return response()->json($userCliente);
    }

    /**
     * Atualiza a conta do Usuário e os campos da Conta corrente que possuem o mesmo nome
     */
    public function updateCliente(Request $request, $id) {
        
        //----Update User Cliente
        $user = User::find($id);

        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->cpf = $request->cpf;
        $user->telefone_1 = $request->telefone_1;
        $user->telefone_2 = $request->telefone_2;
        $user->cep = $request->cep;
        $user->logradouro = $request->logradouro;
        $user->complemento = $request->complemento;
        $user->bairro = $request->bairro;
        $user->municipio = $request->municipio;
        $user->estado = $request->estado;

        $user->save();
        //---------------------------------------------------------

        //------Atualizando conta do User (user_name, user_last_name, cpf)
        $contaUser = Conta::where('user_id', $id)->first();
        
        $contaUser->user_name = $request->name;
        $contaUser->user_last_name = $request->last_name;
        $contaUser->cpf = $request->cpf;
        //$contaUser->num_conta = $contaUser->num_conta; //recebe o mesmo valor porque não pode ser nullo
        //$contaUser->user_id = $contaUser->user_id;
        //$contaUser->saldo = $contaUser->saldo;
        $contaUser->save();
        //------------------------------------------------------------------------------------------------
        
        return response()->json([
            'user' => $user,
            'conta' => $contaUser
        ]);
    }

    public function changePassword(Request $request) { 
        $user = User::where('cpf', $request->cpf)->first(); //encontra usuário 

        if(Hash::check($request->currentPassword, $user->password)){  //verifica se a senha informada no formulario é igual a senha no banco de dados. Hash:check é usado para verifica senha criptografada
            $user->password = Hash::make($request->newPasswowrd); //altera a senha com hash
            $user->save();
            return response()->json(['msg' => 'Senha alterada com sucesso!']);
        }else{
            return response()->json(['msg' => 'Senha atual incorreta!']);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
