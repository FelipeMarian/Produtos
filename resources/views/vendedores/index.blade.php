@extends('layouts.app')
@section('title','Listagem de Vendedores')
@section('content')
    <h1>Listagem de Vendedores</h1>
    @if(Session::has('mensagem'))
        <div class="alert alert-info">
            {{Session::get('mensagem')}}
        </div>
    @endif
    {{Form::open(['url'=>'vendedores/buscar','method'=>'GET'])}}
        <div class="row">
            @if ((Auth::check()) && (Auth::user()->isAdmin()))
                <div class="col-sm-3">
                    <a class="btn btn-success" href="{{url('vendedores/create')}}">Adicionar</a>
                </div>
            @endif
            <div class="col-sm-9">
                <div class="input-group ml-5">
                    @if($busca !== null)
                        &nbsp;<a class="btn btn-info" href="{{url('vendedores/')}}">Todos</a>&nbsp;
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
        @foreach ($vendedores as $vendedor)
            <tr>
                <td>
                    <a href="{{url('vendedores/'.$vendedor->id)}}">{{$vendedor->nome}}</a>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $vendedores->links() }}
@endsection