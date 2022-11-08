@extends('layouts.app')
@section('title','Editar Vendedor')
@section('content')
<br>
    <h1>Alteração de Vendedor</h1>
@if(Session::has('mensagem'))
    <div class="alert alert-success">
        {{Session::get('mensagem')}}
    </div>    
@endif
<br>
{{Form::open(['route' => ['vendedores.update', $vendedor->id], 'method' => 'PUT','enctype'=>'multipart/form-data'])}}

{{Form::label('nome', 'Nome')}}
{{Form::text('nome',$vendedor->nome, ['class'=>'form-control', 'required', 'placeholder' =>'Nome do Vendedor'])}}

{{Form::label('telefone', 'Telefone')}}
{{Form::text('telefone',$vendedor->telefone, ['class'=>'form-control', 'required', 'placeholder' =>'(xx) xxxxx-xxxx'])}}

{{Form::label('email', 'e-mail')}}
{{Form::email('email',$vendedor->email, ['class'=>'form-control', 'required', 'placeholder' =>'E-mail'])}}

{{Form::label('foto', 'Foto')}}
{{Form::file('foto',['class'=>'form-control','id'=>'foto'])}}

<br>
{{Form::submit('Salvar', ['class'=>'btn btn-success'])}}
{!!Form::button('Cancelar', ['onclick'=>'javascript:history.go(-1)','class'=> 'btn btn-danger'])!!}
{{Form::close()}}
@endsection