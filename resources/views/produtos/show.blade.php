@extends('layouts.app')
@section('title',''.$produto->nome)
@section('content')
    <div class="card w-50 m-auto">
        @php
            $nomeimagem = "";
            if(file_exists("./img/produtos/".md5($produto->id).".jpg")) {
                $nomeimagem = "./img/produtos/".md5($produto->id).".jpg";
            } elseif (file_exists("./img/produtos/".md5($produto->id).".png")) {
                $nomeimagem = "./img/produtos/".md5($produto->id).".png";
            } elseif (file_exists("./img/produts/".md5($produto->id).".gif")) {
                $nomeimagem =  "./img/produtos/".md5($produto->id).".gif";
            } elseif (file_exists("./img/produtos/".md5($produto->id).".webp")) {
                $nomeimagem = "./img/produtos/".md5($produto->id).".webp";
            } elseif (file_exists("./img/produtos/".md5($produto->id).".jpeg")) {
                $nomeimagem = "./img/produtos/".md5($produto->id).".jpeg";
            } else {
                $nomeimagem = "./img/produtos/semfoto.webp";
            }
            //echo $nomeimagem;
        @endphp

        {{Html::image(asset($nomeimagem),'Foto de '.$produto->nome,["class"=>"img-thumbnail"])}}

        <div class="card-header">
            <h1>{{$produto->titulo}}</h1>
        </div>
        <div class="card-body">
                <h3 class="card-title">{{$produto->nome}}</h3>
                <p class="text">
                Quantidade: {{$produto->quantidade}}
                <br/>
                Valor: R${{$produto->valor}}
                <br/>
                Vendedor: {{$produto->vendedor->nome}}
                <br/>
                Data de Emissão: {{$produto->dataHoje}}
                <br/>
                Data de Validade: {{$produto->dataValidade}}
            </p>
        </div>
        <div class="card-footer">
            @if ((Auth::check()) && (Auth::user()->isAdmin()))
                {{Form::open(['route' => ['produtos.destroy',$produto->id],'method' => 'DELETE'])}}
                @if ($nomeimagem !== "./img/produtos/semfoto.webp")
                {{Form::hidden('foto',$nomeimagem)}}
                @endif
                <a href="{{url('produtos/'.$produto->id.'/edit')}}" class="btn btn-success">Alterar</a>
                {{Form::submit('Excluir',['class'=>'btn btn-danger','onclick'=>'return confirm("Confirma exclusão?")'])}}
            @endif
                <a href="{{url('produtos/')}}" class="btn btn-secondary">Voltar</a>
            @if ((Auth::check()) && (Auth::user()->isAdmin()))
                {{Form::close()}}
            @endif

        </div>
    </div>
@endsection