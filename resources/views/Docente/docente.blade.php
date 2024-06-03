@extends('adminlte::page')

@section('title', 'CRUD')

@section('content_header')
<h1>Bienvenidos</h1>
@stop

@section('content')
@if(isset($reserva) && $estado !== 'confirmado')
<!-- Verifica si la reserva existe y su estado no es "confirmado" -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Detalles de la Reserva
            </div>
            <div class="card-body">
                <p><strong>Solicitante:</strong> {{ $reserva['docente'] }}</p>
                <p><strong>Número de reserva:</strong> {{ $reserva['id'] }}</p>
                <p><strong>Fecha y hora:</strong> {{ $reserva['fecha_reserva'] }}</p>
                <p><strong>Grupo:</strong> {{ $reserva['grupo'] }}</p>
                <p><strong>Materia:</strong> {{ $reserva['materia'] }}</p>
                <p><strong>Motivo:</strong> {{ $reserva['acontecimiento'] }}</p>
                <p><strong>Horario:</strong> {{ $reserva['horario'] }}</p>
                <p><strong>Tipo Ambiente:</strong> {{ $reserva['tipo_ambiente'] }}</p>
                <p><strong>Ambientes Disponibles:</strong></p>
                <div class="card-footer">
                    <form id="reserva-form"
                        action="{{ route('confirmar-solicitud', ['id' => $reserva['id'], 'action' => 'default']) }}"
                        method="POST">
                        @csrf
                        <ul>
                            @foreach($ambientes as $ambiente)
                            <li>
                                <input type="checkbox" name="ambientes[]" value="{{ $ambiente }}" checked>
                                {{ $ambiente }}
                            </li>
                            @endforeach
                        </ul>
                        <!-- Botones de acción -->
                        <button type="button" class="btn btn-danger" onclick="submitForm('rechazar')">Rechazar</button>
                        <button type="button" class="btn btn-success"
                            onclick="submitForm('confirmar')">Confirmar</button>
                    </form>

                    <script>
                    function submitForm(action) {
                        const form = document.getElementById('reserva-form');
                        form.action = form.action.replace('default', action);
                        form.submit();
                    }
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>
@else
<p>No se encontró información de la reserva o la reserva está confirmada.</p>
@endif

@stop