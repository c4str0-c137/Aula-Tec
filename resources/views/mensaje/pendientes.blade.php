<!-- resources/views/reservas/pendientes.blade.php -->

@extends('adminlte::page')

@section('title', 'Reservas Pendientes')

@section('content_header')
<h1>Reservas Pendientes</h1>
@endsection

@section('content')
@if($reservas->isEmpty())
<div class="alert alert-info" role="alert">
    No hay reservas pendientes.
</div>
@else
<div class="container">
    <div style="overflow-x: auto;">
        <table id="notificaciones" class="table table-striped table-bordered">
            <thead class="bg-primary text-white">
                <tr>
                    <th>ID</th>
                    <th>Fecha de Reserva</th>
                    <th>Docente</th>
                    <th>Materia</th>
                    <th>Grupo</th>
                    <th>Horario</th>
                    <th>Estados</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->id }}</td>
                    <td>{{ $reserva->fecha_reserva }}</td>
                    <td>{{ $reserva->docente }}</td>
                    <td>{{ $reserva->materia }}</td>
                    <td>{{ $reserva->grupo }}</td>
                    <td>{{ $reserva->horario }}</td>
                    <td>{{ $reserva->estado }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
</div>
@endsection