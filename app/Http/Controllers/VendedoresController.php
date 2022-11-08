<?php

namespace App\Http\Controllers;

use App\Models\Vendedores;
use App\Models\Produto;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;

class VendedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendedores = Vendedores::paginate(5);
        return view('vendedores.index',array('vendedores' => $vendedores,'busca'=>null));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function buscar(Request $request) {
        $vendedores = Vendedores::where('nome','LIKE','%'.$request->input('busca').'%')->orwhere('telefone','LIKE','%'.$request->input('busca').'%')->paginate(5);
        return view('vendedores.index',array('vendedores' => $vendedores,'busca'=>$request->input('busca')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $vendedores = Vendedores::all();
            $produtos = Produto::all();
            return view('vendedores.create',['vendedores'=>$vendedores]);
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
                'telefone'=>'required',
                'email'=>'required',
            ]);
            $vendedor = new Vendedores();
            $vendedor->nome = $request->input('nome');
            $vendedor->telefone = $request->input('telefone');
            $vendedor->email = $request->input('email');
            if($vendedor->save()) {
                if($request->hasFile('foto')){
                    $imagem = $request->file('foto');
                    $nomearquivo = md5($vendedor->id).".".$imagem->getClientOriginalExtension();
                    //dd($imagem, $nomearquivo,$contato->id);
                    $request->file('foto')->move(public_path('.\img\vendedores'),$nomearquivo);
                }
                return redirect('vendedores');
            }
        } else {
            return redirect('login');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendedores  $vendedores
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendedor = Vendedores::find($id);
        return view('vendedores.show',array('vendedor' => $vendedor));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendedores  $vendedores
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $vendedor = Vendedores::find($id);
            return view('vendedores.edit',array('vendedor' => $vendedor));
        } else {
            return redirect('login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendedores  $vendedores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $this->validate($request,[
                'nome'=>'required',
                'telefone'=>'required',
                'email'=>'required',
            ]);
            $vendedor = Vendedores::find($id);
            if($request->hasFile('foto')){
                $imagem = $request->file('foto');
                $nomearquivo = md5($vendedor->id).".".$imagem->getClientOriginalExtension();
                $request->file('foto')->move(public_path('.\img\vendedores'),$nomearquivo);
            }
            $vendedor->nome = $request->input('nome');
            $vendedor->telefone = $request->input('telefone');
            $vendedor->email = $request->input('email');
            if($vendedor->save()) {
                Session::flash('mensagem','Vendedor alterado com sucesso');
                return redirect()->back();
            }
        } else {
            return redirect('login');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendedores  $vendedores
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendedores $vendedores,$id)
    {
        if ((Auth::check()) && (Auth::user()->isAdmin())) {
            $vendedor = Vendedores::find($id);
            if (isset($request->foto)) {
            unlink($request->foto);
            }
            $vendedor->delete();
            Session::flash('mensagem','Vendedor Excluído com Sucesso Foto:');
            return redirect(url('vendedores/'));
        } else {
            return redirect('login');
        }
    }
}
