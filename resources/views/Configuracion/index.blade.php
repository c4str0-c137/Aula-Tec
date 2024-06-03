@extends('adminlte::page')

@section('title', 'Configuracion Solicitudes')

@section('content_header')
    @if(Auth::check() && Auth::user()->id_rol === 1)
        <h1>Configuracion Solicitudes</h1>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('guardar_configuracion') }}" method="POST" id="configuracion_form">
                    @csrf
                    <div class="mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha de inicio para la reserva</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ $configuracion->fecha_inicio ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="fecha_fin" class="form-label">Fecha de fin para la reserva</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ $configuracion->fecha_fin ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="cantidad_periodos" class="form-label">Cantidad de periodos a seleccionar</label>
                        <input type="number" class="form-control" id="cantidad_periodos" name="cantidad_periodos" value="{{ $configuracion->periodos ?? '' }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    @endif
@stop
