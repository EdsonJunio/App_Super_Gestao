<?php

namespace App\Http\Controllers;

use App\Produto;
use App\Unidade;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{

    public function index(Request $request)
    {
        $produtos = Produto::paginate(10);

        return view('app.produto.index', ['produtos' => $produtos, 'request' => $request->all()]);
    }


    public function create()
    {
        $unidades = Unidade::all();
        return view('app.produto.create', ['unidades' => $unidades]);
    }


    public function store(Request $request)
    {
        $regras = [
            'nome' => 'required|min:3|max:40',
            'descricao' => 'required|min:3|max:1000',
            'peso' => 'required|integer',
            'unidade_id' => 'exists:unidades,id'
        ];

        $feedback = [
            'required' => 'O campo attribute deve ser preenchido',
            'nome.min' => 'O campo nome deve ter no minimo 3 caracteres',
            'nome.max' => 'O campo nome deve ter no maximo 40 caracteres',
            'descricao.min' => 'O campo descricao deve ter no minimo 3 caracteres',
            'descricao.max' => 'O campo descricao deve ter no maximo 1000 caracteres',
            'peso.interger' => 'O campo peso deve ser um numero inteiro',
            'unidade_id.exists' => 'A unidade de medida informada nao existe',
        ];

        $request->validate($regras, $feedback);

        Produto::create($request->all());
        return redirect()->route('produto.index');
    }


    public function show(Produto $produto)
    {
        return view('app.produto.show', ['produto' => $produto]);
    }


    public function edit(Produto $produto)
    {
        $unidades = Unidade::all();
        //return view('app.produto.edit', ['produto' => $produto, 'unidades' => $unidades]);
        return view('app.produto.create', ['produto' => $produto, 'unidades' => $unidades]);
    }


    public function update(Request $request, Produto $produto)
    {
        $produto->update($request->all());
        return redirect()->route('produto.show', ['produto' => $produto->id]);
    }


    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('produto.index');
    }
}
