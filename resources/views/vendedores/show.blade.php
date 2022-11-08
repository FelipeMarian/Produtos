@extends('layouts.app')
@section('title',''.$vendedor->nome)
@section('content')
    <div class="card w-50 m-auto">
        @php
            $nomeimagem = "";
            if(file_exists("./img/vendedores/".md5($vendedor->id).".jpg")) {
                $nomeimagem = "./img/vendedores/".md5($vendedor->id).".jpg";
            } elseif (file_exists("./img/vendedores/".md5($vendedor->id).".png")) {
                $nomeimagem = "./img/vendedores/".md5($vendedor->id).".png";
            } elseif (file_exists("./img/vendedores/".md5($vendedor->id).".gif")) {
                $nomeimagem =  "./img/vendedores/".md5($vendedor->id).".gif";
            } elseif (file_exists("./img/vendedores/".md5($vendedor->id).".webp")) {
                $nomeimagem = "./img/vendedores/".md5($vendedor->id).".webp";
            } elseif (file_exists("./img/vendedores/".md5($vendedor->id).".jpeg")) {
                $nomeimagem = "./img/vendedores/".md5($vendedor->id).".jpeg";
            } else {
                $nomeimagem = "./img/vendedores/semfoto.webp";
            }
            //echo $nomeimagem;
        @endphp

        {{Html::image(asset($nomeimagem),'Foto de '.$vendedor->nome,["class"=>"img-thumbnail"])}}

        <div class="card-header">
            <h1>{{$vendedor->titulo}}</h1>
        </div>
        <div class="card-body">
                <h3 class="card-title">{{$vendedor->nome}}</h3>
                <p class="text">
                Telefone: {{$vendedor->telefone}}
                <br/>
                E-Mail: {{$vendedor->email}}
            </p>
        </div>
        <div class="card-footer">
            @if ((Auth::check()) && (Auth::user()->isAdmin()))
                {{Form::open(['route' => ['vendedores.destroy',$vendedor->id],'method' => 'DELETE'])}}
                @if ($nomeimagem !== "./img/vendedores/semfoto.webp")
                {{Form::hidden('foto',$nomeimagem)}}
                @endif
                <a href="{{url('vendedores/'.$vendedor->id.'/edit')}}" class="btn btn-success">Alterar</a>
                {{Form::submit('Excluir',['class'=>'btn btn-danger','onclick'=>'return confirm("Confirma exclusão?")'])}}
            @endif
                <a href="{{url('vendedores/')}}" class="btn btn-secondary">Voltar</a>
            @if ((Auth::check()) && (Auth::user()->isAdmin()))
                {{Form::close()}}
            @endif

        </div>
    </div>
@endsection