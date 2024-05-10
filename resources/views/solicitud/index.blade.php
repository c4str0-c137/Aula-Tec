<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
@extends('adminlte::page')

@section('title', 'Listado de Reservas')

@section('content_header')
    <h1>Listado de reservas</h1>
@stop

@section('content')
    <a href="{{ route('Horario.create') }}" class="btn btn-primary mb-3">CREAR</a>
    @if(Auth::check() && Auth::user()->id_rol === 1)
        <div class="container-fluid">
    <div class="container">
        <div style="overflow-x: auto;">
            <table id="ambienteHorariosTable" class="table table-striped table-bordered">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Solicitante</th>
                        <th>Motivo</th>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Grupo</th>
                        <th>Materia</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($reservas as $reserva)
                    <tr>
                        <td>{{ $reserva  }}</td>
                        <td>{{ $reserva  }}</td>
                        <td>{{ $reserva  }}</td>
                        <td>{{ $reserva  }}</td>
                        <td>{{ $reserva  }}</td>
                        <td>{{ $reserva  }}</td>
                        <td>{{ $reserva  }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@stop

@section('css')
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@stop