@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Asignación de Ambiente</h1>
@stop

@section('content')
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <form id="form-buscar-ambientes" action="{{ route('confirmarReserva', ['id' => $id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tipo">N° Reserva</label>
                        <input type="text" id="tipo" name="tipo" class="form-control" value="Numero de reserva: {{ $id }}" readonly>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-info assign-btn">Confirmar Solicitud</button>
                    </div>
                </div>
                <div class="col-md-6 d-none">
                    <div class="mb-3">
                        <label for="capacidad">Capacidad</label>
                        <input type="text" id="capacidad" name="capacidad" class="form-control" value="{{ $capacidad }}" readonly>
                    </div>
                </div>
                <div class="col-md-6 d-none">
                    <div class="mb-3">
                        <label for="tipo_ambiente">Tipo de Ambiente</label>
                        <input type="text" id="tipo_ambiente" name="tipo_ambiente" class="form-control" value="{{ $tipo_ambiente }}" readonly>
                    </div>
                </div>
                <div class="col-md-6 d-none">
                    <div class="mb-3">
                        <label for="horario">Horario</label>
                        <input type="text" id="horario" name="horario" class="form-control" value="{{ $horario }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="ambientes_disponibles">Ambientes Disponibles</label>
                        <select id="ambientes_disponibles" name="ambientes_disponibles" class="form-control">
                            {{-- Los resultados de la consulta se agregarán aquí mediante JavaScript --}}
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div id="resultadoAsignacion"></div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let form = document.getElementById('form-buscar-ambientes');
            let formData = new FormData(form);

            fetch('{{ route('buscarAmbientes') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                
                let select = document.getElementById('ambientes_disponibles');
                select.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(ambiente => {
                        let option = document.createElement('option');
                        option.value = ambiente.numeroaula;
                        option.textContent = ambiente.numeroaula;
                        select.appendChild(option);
                    });
                } else {
                    let option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No hay ambientes disponibles';
                    select.appendChild(option);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
@stop
