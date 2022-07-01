@extends('adminlte::page')

@section('title', 'Confirmar Transferência')

@section('content_header')
  <h1>Confirmar Transferência</h1>

  <ol class="breadcrumb">
    <li><a href="">Dashboard</a></li>
    <li><a href="">Saldo</a></li>
    <li><a href="">Transferir</a></li>
    <li><a href="">Confirmação</a></li>
  </ol>
@stop

@section('content')
  <div class="box">
    <div class="box-header">
      <h3>Confirmar Transferência Saldo</h3>
    </div>

    <div class="box-body">
      @include('admin.includes.alerts')

      <p><strong>Recebedor: </strong>{{$sender->name}}</p>
      <p><strong>Seu saldo atual: </strong>{{number_format($balance->amount, 2, ',', '.')}}</p>

      <form action="{{route('transfer.store')}}" method="POST">
        {!! csrf_field() !!}
        <input type="hidden" name="sender_id" value="{{$sender->id}}">
        <div class="form-group">
          <input type="text" name="value" class="form-control" placeholder="Valor:">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-success">Transferir</button>
        </div>
      </form>
    </div>
  </div>
@stop