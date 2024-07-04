<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\pessoaFisica;

class projetoTestesController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index(){

        $cpfs = pessoaFisica::select('cpf', 'nome', 'sobrenome', 'nascimento', 'email', 'genero')->get();
        return view("home")->with('cpfs', $cpfs);

    }

    public function cadPessoaFisica(Request $request){
        return view("cadpessoafisica");
    }

    public function updatePessoaFisica($cpf){

        $cadastro = pessoaFisica::where('cpf',$cpf)->get();
        return view("updatepessoafisica")->with('cadastro', $cadastro);

    }

    public function cadCPF(Request $request){

        $cpf = pessoaFisica::find($request->cpf);

        if ($cpf == ''){
            $request->validate([
                'cpf' => 'required|string|max:255',
                'nome' => 'required|string|max:255',
                'sobrenome' => 'required|string|max:255',
                'nascimento' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'genero' => 'required|string|max:255',
            ]);

            $cadastroCPF = new pessoaFisica();
            $cadastroCPF->cpf = $request->cpf;
            $cadastroCPF->nome = $request->nome;
            $cadastroCPF->sobrenome = $request->sobrenome;
            $cadastroCPF->nascimento = $request->nascimento;
            $cadastroCPF->email = $request->email;
            $cadastroCPF->genero = $request->genero;

            $cadastroCPF->save();

            return response()->json(['cadastro' => 'true']);
        } else {
            return response()->json(['cadastro' => 'false']);
        }
    }

    public function delCPF(Request $request){

        $res = pessoaFisica::where('cpf',$request->cpf)->delete();
        return response()->json(['delete' => 'true']);

    }

    public function alteraCPF(Request $request)
    {

        $cpf = pessoaFisica::find($request->cpf);

        $request->validate([
            'cpf' => 'required|string|max:255',
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'nascimento' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'genero' => 'required|string|max:255',
        ]);

        $cpf->nome = $request->nome;
        $cpf->sobrenome = $request->sobrenome;
        $cpf->nascimento = $request->nascimento;
        $cpf->email = $request->email;
        $cpf->genero = $request->genero;

        $cpf->save();

        return response()->json(['cadastro' => 'true']);

    }
}
