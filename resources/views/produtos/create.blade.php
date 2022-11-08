@extends('layouts.app')
@section('title','Adicionar Produto')
@section('content')
<br>
    <h1>Adicionar Produto</h1>
<br>
{{Form::open(['route' => 'produtos.store', 'method' => 'POST', 'enctype'=>'multipart/form-data'])}}  

{{Form::label('nome', 'Nome')}}
{{Form::text('nome', '', ['class'=>'form-control', 'required', 'placeholder' =>'Nome do Produto'])}}

{{Form::label('idVendedor', 'Vendedor')}}
{{Form::text('idVendedor', '', ['class'=>'form-control', 'required', 'placeholder' =>'Selecione um Vendedor','list'=>'listvendedores'])}} 
    <datalist id='listvendedores'>
        @foreach($vendedores as $vendedor)  
            <option value="{{$vendedor->id}}">{{$vendedor->nome}}</option>
        @endforeach
    </datalist>

{{Form::label('quantidade', 'Quantidade do Produto')}}
{{Form::text('quantidade', '', ['class'=>'form-control', 'required', 'placeholder' =>'Quantidade'])}}

{{Form::label('valor', 'valor')}}
{{Form::text('valor', '',['class'=>'form-control', 'required', 'placeholder' =>'Valor', 'rows'=>'8'])}}

{{Form::label('dataValidade', 'Data Validade')}}
{{Form::text('dataValidade', \Carbon\Carbon::now()->addDays(15), ['class'=>'form-control', 'required', 'placeholder' =>'Data de Validade'])}}

{{Form::label('dataHoje', 'Data Hoje')}}
{{Form::text('dataHoje', \Carbon\Carbon::now(), ['class'=>'form-control', 'required', 'placeholder' =>'Data'])}}

{{Form::label('foto', 'Foto')}}
{{Form::file('foto',['class'=>'form-control','id'=>'foto'])}}

<br>
{{Form::submit('Salvar', ['class'=>'btn btn-success'])}}
{!!Form::button('Cancelar', ['onclick'=>'javascript:history.go(-1)','class'=> 'btn btn-danger'])!!}
{{Form::close()}}
@endsection