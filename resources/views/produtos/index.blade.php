@extends('layouts.app')
@section('title','Listagem de Contatos')
@section('content')
    <h1>Listagem de Produtos</h1>
    @if(Session::has('mensagem'))
        <div class="alert alert-info">
            {{Session::get('mensagem')}}
        </div>
    @endif
    {{Form::open(['url'=>'produtos/buscar','method'=>'GET'])}}
        <div class="row">
            @if ((Auth::check()) && (Auth::user()->isAdmin()))
                <div class="col-sm-3">
                    <a class="btn btn-success" href="{{url('produtos/create')}}">Adicionar</a>
                </div>
            @endif
            <div class="col-sm-9">
                <div class="input-group ml-5">
                    @if($busca !== null)
                        &nbsp;<a class="btn btn-info" href="{{url('produtos/')}}">Todos</a>&nbsp;
                    @endif
                    {{Form::text('busca',$busca,['class'=>'form-control','required','placeholder'=>'buscar'])}}
                    &nbsp;
                    <span class="input-group-btn">
                        {{Form::submit('Buscar',['class'=>'btn btn-secondary'])}}
                    </span>
                </div>
            </div>
        </div>
    {{Form::close()}}
    <br />
    <table class="table table-striped">
        @foreach ($produtos as $produto)
            <tr>
                <td>
                    <a href="{{url('produtos/'.$produto->id)}}">{{$produto->nome}}</a>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $produtos->links() }}
@endsection