@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Asignación de Ambiente</h1>
@stop

@section('content')
    @if(session('message'))
        <div class="custom-success-message">
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
                </div>
                <div class="col-md-6">
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
                        <label for="departamento">Departamento</label>
                        <select id="departamento" name="departamento" class="form-control">
                            <option value="">Seleccione un Departamento</option>
                            @foreach($departamentos as $departamento)
                                <option value="{{ $departamento }}">{{ $departamento }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="ubicacion">Ubicación</label>
                        <select id="ubicacion" name="ubicacion" class="form-control">
                            <option value="">Seleccione una Ubicación</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="ambientes_disponibles" class="mb-3">
                        <label for="ambientes">Aulas Disponibles</label>
                        <div id="lista-ambientes"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-info assign-btn">Confirmar Solicitud</button>
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
            let departamentoSelect = document.getElementById('departamento');
            let ubicacionSelect = document.getElementById('ubicacion');
            let horario = '{{ $horario }}';
            let listaAmbientes = document.getElementById('lista-ambientes');

            departamentoSelect.addEventListener('change', fetchUbicaciones);
            ubicacionSelect.addEventListener('change', fetchAmbientes);

            function fetchUbicaciones() {
                let departamento = departamentoSelect.value;
                ubicacionSelect.innerHTML = '<option value="">Seleccione una Ubicación</option>';
                listaAmbientes.innerHTML = '';

                if (departamento) {
                    fetch('{{ route('getUbicaciones') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ departamento: departamento })
                    })
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(ubicacion => {
                            let option = document.createElement('option');
                            option.value = ubicacion;
                            option.textContent = ubicacion;
                            ubicacionSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
                }
            }

            function fetchAmbientes() {
                let departamento = departamentoSelect.value;
                let ubicacion = ubicacionSelect.value;
                listaAmbientes.innerHTML = '';

                if (departamento && ubicacion) {
                    fetch('{{ route('get.ambientes') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ departamento: departamento, ubicacion: ubicacion, horario: horario })
                    })
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(ambiente => {
                            let div = document.createElement('div');
                            let input = document.createElement('input');
                            input.type = 'checkbox';
                            input.name = 'ambientes[]';
                            input.value = ambiente.numeroaula;
                            let label = document.createElement('label');
                            label.textContent = ` ${ambiente.numeroaula} (Capacidad: ${ambiente.capacidad})`;
                            div.appendChild(input);
                            div.appendChild(label);
                            listaAmbientes.appendChild(div);
                        });
                    })
                    .catch(error => console.error('Error:', error));
                }
            }
            $('#solicitudForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    // Mostrar SweetAlert2 solo si hay información en la sesión
                    if ("{{ session('message') }}") {
                        showConfirmationMessage();
                    }
                },
                error: function(xhr, status, error) {
                    // Manejar errores si es necesario
                }
            });
        });
        });
    </script>
@stop
