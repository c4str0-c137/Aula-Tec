@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    
    <h1>Ambientes Disponibles</h1>

    <!-- Mostrar los datos de la solicitud -->
@stop

@section('content')
    <form action="{{ route('buscarAmbientes') }}" method="POST">
        @csrf
        <!-- Agrega aquí tus campos de formulario -->
        <!-- Por ejemplo, puedes agregar campos input para los criterios de búsqueda -->
        <!-- <div class="form-group">
            <label for="tipo">Tipo de Ambiente:</label>
            <input type="text" id="tipo" name="tipo" class="form-control">
        </div> -->
        <!-- Aquí estaba el campo de horario -->
        <!-- <div class="form-group">
            <label for="horario">Horario:</label>
            <input type="time" id="horario" name="horario" class="form-control">
        </div> -->
        <!-- Agrega aquí más campos de formulario según tus necesidades -->
        
        <!-- No hay botón en este formulario -->
    </form>

    <!-- Contenedor para mostrar los resultados de la asignación -->
    <div id="resultadoAsignacion"></div>

    <!-- Script para la consulta de ambientes disponibles -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
    $(document).ready(function() {
        // No hay evento de clic para un botón que no existe
    });
    </script>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
