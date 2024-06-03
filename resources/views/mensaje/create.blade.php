@extends('adminlte::page')

@section('title', 'CRUD')

@section('content_header')
    <h1>Enviar Notificaciones</h1>
    @if(session('message'))
        <div class="custom-success-message">
            {{ session('message') }}
        </div>
    @endif
    <form action="{{ route('mensaje.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label>Title</label>
      <input type="text" class="form-control" name="materia" placeholder="Enter your title here">
    </div>
    <div class="form-group">
      <label>Description</label>
      <input type="text" class="form-control" name="grupo" placeholder="Enter description here">
    </div>
    <button class="btn btn-dark" type="submit">Submit</button>
    </form>
@endsection