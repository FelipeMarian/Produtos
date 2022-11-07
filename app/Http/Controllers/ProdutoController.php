<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Vendedores;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = Produto::paginate(5);
        return view('produtos.index',array('produtos' => $produtos,'busca'=>null));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscar(Request $request) {
        $produtos = Produto::where('nome','LIKE','%'.$request->input('busca').'%')->orwhere('idVendedor','LIKE','%'.$request->input('busca').'%')->paginate(5);
        return view('produtos.index',array('produtos' => $produtos,'busca'=>$request->input('busca')));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $produtos = Produto::all();
            return view('produtos.create',['produtos'=>$produtos]);
        }
        else {
            return redirect('login');
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
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $this->validate($request,[
                'nome'=>'required',
                'idVendedor'=>'required',
                'quantidade'=>'required',
                'valor'=>'required',
                'dataValidade'=>'required',
                'dataHoje'=>'required',
            ]);
            $produto = new Produto();
            $produto->nome = $request->input('nome');
            $produto->idVendedor = $request->input('idVendedor');
            $produto->quantidade = $request->input('quantidade');
            $produto->valor = $request->input('valor');
            $produto->dataValidade = \Carbon\Carbon::now()->addDays(15);
            $produto->dataHoje = \Carbon\Carbon::now();
            if($noticia->save()) {
                if($request->hasFile('foto')){
                    $imagem = $request->file('foto');
                    $nomearquivo = md5($produto->id).".".$imagem->getClientOriginalExtension();
                    //dd($imagem, $nomearquivo,$contato->id);
                    $request->file('foto')->move(public_path('.\img\produtos'),$nomearquivo);
                }
                return redirect('produtos');
            }
        } else {
            return redirect('login');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto = Produto::find($id);
        return view('produtos.show',array('produto' => $produto));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $produto = Produto::find($id);
            $vendedores = Vendedores::all();
            return view('produto.edit',array('produto' => $produto,'vendedores'=>$vendedores));
        } else {
            return redirect('login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $this->validate($request,[
                'nome'=>'required',
                'idVendedor'=>'required',
                'quantidade'=>'required',
                'valor'=>'required',
                'dataValidade'=>'required',
                'dataHoje'=>'required',
            ]);
            $produto = new Produto();
            if($request->hasFile('foto')){
                $imagem = $request->file('foto');
                $nomearquivo = md5($produto->id).".".$imagem->getClientOriginalExtension();
                $request->file('foto')->move(public_path('.\img\produtos'),$nomearquivo);
            }
            $produto->nome = $request->input('nome');
            $produto->idVendedor = $request->input('idVendedor');
            $produto->quantidade = $request->input('quantidade');
            $produto->valor = $request->input('valor');
            $produto->dataValidade = \Carbon\Carbon::now()->addDays(15);
            $produto->dataHoje = \Carbon\Carbon::now();
            if($noticia->save()) {
                Session::flash('mensagem','Produto alterado com sucesso');
                return redirect()->back();
            }
        } else {
            return redirect('login');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto,$id)
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $produto = Produto::find($id);
            if (isset($request->foto)) {
            unlink($request->foto);
            }
            $produto->delete();
            Session::flash('mensagem','Produto Excluído com Sucesso Foto:');
            return redirect(url('produtos/'));
        } else {
            return redirect('login');
        }
    }
}
