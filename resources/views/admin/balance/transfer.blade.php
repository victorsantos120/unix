@extends('adminlte::page')

@section('title', 'Transferir Saldo')

@section('content_header')
  <h1>Fazer Transferência</h1>

  <ol class="breadcrumb">
    <li><a href="">Dashboard</a></li>
    <li><a href="">Saldo</a></li>
    <li><a href="">Transferir</a></li>
  </ol>
@stop

@section('content')
  <div class="box">
    <div class="box-header">
      <h3>Tranferir Saldo (Informe o Recebedor)</h3>
    </div>

    <div class="box-body">
      @include('admin.includes.alerts')

      <form action="{{route('confirm.transfer')}}" method="POST">
        {!! csrf_field() !!}
        <div class="form-group">
          <input type="text" name="sender" class="form-control" placeholder="Informação de quem vai receber o valor (Nome ou E-mail)">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-success">Próxima Etapa</button>
        </div>
      </form>
    </div>
  </div>
@stop