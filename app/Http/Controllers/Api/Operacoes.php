<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conta;
use Illuminate\Support\Facades\Hash; //para fazer o hash da senha antes de comparar com a que está no banco

class Operacoes extends Controller
{
    /**
     * Função criada para retirar caracteres especiais do valor e transforma-lo em numero
     */
    public function maskOff($valorInformado){
        
        // Transformação da string em float
        $resultado = str_replace("R$", "", $valorInformado); //subistitui "R$" por ""
        $resultado = str_replace(".", "", $resultado); //substitui "." por "" tirar o separador de milhares
        $resultado = str_replace(",", ".", $resultado); //subistitui "," por "." - O ponto agora será o separador das casas decimais
        $resultado = floatval($resultado); // função floatval() transforma a string do parâmetro em ponto flutuante (consultar documentação php)

        return $resultado;
    }

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
     * Saque
     * Realiza saque, se a conta tiver saldo sufuciente
     */
    public function saque(Request $request)
    {
        $user = User::where('cpf', $request->cpf)->first(); //encontra o user
        
        if(Hash::check($request->password, $user->password)){ //verifica se a senha informada no formulario é igual a senha no banco de dados. Hash:check é usado para verifica senha criptografada

            $conta = Conta::where('cpf', $request->cpf)->first(); //encontra a conta bancaria do user

            $valor = $this->maskOff($request->valor); //chamando função maskOff (função criada para retirar caracteres especiais)

            if($conta->saldo >= $valor){
                $conta->saldo = $conta->saldo - $valor;
                $conta->save();
                return response()->json($conta);
            }else{
                return response()->json(['msg' => 'Saldo insuficiente!']);
            }

         }else{
            return response()->json(['msg' => 'Senha incorreta!']);
        }
    }

    /**
     * TRANSFERÊNCIA
     * Se o usuário que quer transferir digitar a senha correta
     * Verifica se tem saldo suficiente
     * Transfere valor para a conta que vai receber
     * Desconta valor transferido
     * Mensagens de senha incorreta, saldo insuficiente e de sucesso, são enviadas de acordo com as verificações
     */
    public function transferencia(Request $request){
        
        $user = User::where('cpf', $request->cpf)->first(); //encontra o user que quer realizar a transferencia

        if(Hash::check($request->password, $user->password)){ //verifica se a senha informada no formulario é igual a senha no banco de dados. Hash:check é usado para verifica senha criptografada

            $valor = $this->maskOff($request->valor); //chamando função maskOff (função criada para retirar caracteres especiais)

            $contaSender = Conta::where('cpf', $request->cpf)->first(); //encontra a conta que vai transferir o valor
            
            if($contaSender->saldo >= $valor){ //está entrando nesse bloco de comando mesmo quando a condição é false

                //return dd($contaSender->saldo);

                $contaSender->saldo = $contaSender->saldo - $valor;
                $contaSender->save();
    
                $contaReceiver = Conta::where('num_conta', $request->num_conta)->first(); //encontra a conta bancaria que vai receber o valor
                $contaReceiver->saldo = $contaReceiver->saldo + $valor; //conta que recebe valor transferido
                $contaReceiver->save();
                    
                return response()->json(['msg' => 'Transferência concluída com sucesso!']);
            }
            else{
                return response()->json(['msg' => 'Saldo insuficiente!']);
            }
        }else{ //se senha incorreta
            return response()->json(['msg' => 'Senha incorreta!']);
        }
    }

    /**
     * DEPÓSITO
     * Se o usuário que quer depositar digitar a senha correta
     * Deposita valor para a conta que vai receber
     * Mensagens de senha incorreta, saldo insuficiente e de sucesso, são enviadas de acordo com as verificações
     */
    public function deposito(Request $request){
        
        $user = User::where('cpf', $request->cpf)->first(); //encontra o user que quer realizar a deposito

        if(Hash::check($request->password, $user->password)){ //verifica se a senha informada no formulario é igual a senha no banco de dados. Hash:check é usado para verifica senha criptografada


            $contaReceiver = Conta::where('num_conta', $request->num_conta)->first(); //encontra a conta bancaria que vai receber o valor

            $valor = $this->maskOff($request->valor); //chamando função maskOff (função criada para retirar caracteres especiais)

            $contaReceiver->saldo = $contaReceiver->saldo + $valor; //conta que recebe valor transferido
            $contaReceiver->save();
        
            return response()->json(['msg' => 'Depósito concluído com sucesso!']);

        }else{ //se senha errada
            return response()->json(['msg' => 'Senha incorreta!']);
        }
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
