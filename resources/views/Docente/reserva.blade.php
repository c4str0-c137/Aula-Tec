@extends('adminlte::page')

@section('title', 'Solicitud de Reserva')

@section('content_header')
    <h1>Solicitud de Reserva</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('guardar_solicitud') }}" method="POST">
                @csrf
                <div class="mb-3 row">
                    <div class="col">
                        <label for="usuario" class="form-label">Usuario</label>
                        @if(Auth::check() && Auth::user()->name)
                            <input type="text" class="form-control" id="usuario" name="usuario" value="{{ Auth::user()->name }}" readonly>
                        @else
                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Nombre de Usuario" readonly>
                        @endif
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="materia" class="form-label">Materias</label>
                        <select id="materia" name="materia" class="form-control" tabindex="4">
                            <option value="">Seleccione una Materia</option>
                            @foreach($materias as $materia)
                                <option value="{{ $materia }}">{{ $materia }}</option>
                            @endforeach
                        </select>
                        <div id="materiaError" class="text-danger"></div>
                    </div>
                    <div class="col">
                        <label for="grupo" class="form-label">Grupo</label>
                        <select id="grupo" name="grupo" class="form-control" tabindex="4">
                            <option value="">Seleccione un grupo</option>
                        </select>
                        <div id="grupoError" class="text-danger"></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="capacidad" class="form-label">Capacidad</label>
                        <input type="text" id="capacidad" name="capacidad" class="form-control" placeholder="Ingrese la cantidad de alumnos para su ambiente" tabindex="4">
                        <div id="ambienteError" class="text-danger"></div>
                    </div>
                    <div class="col-6">
                        <label for="motivo" class="form-label">Motivo de Reserva</label>
                        <select id="motivo" name="motivo" class="form-control" tabindex="4">
                            <option value="">Seleccione un Motivo</option>
                            @foreach($acontecimientos as $acontecimiento)
                                <option value="{{ $acontecimiento->id }}">{{ $acontecimiento->tipo }}</option>
                            @endforeach
                        </select>
                        <div id="acontecimientoError" class="text-danger"></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="horario" class="form-label">Horario</label>
                        <div class="checkbox-grid">
                            @php $count = 0; @endphp
                            @foreach($horarios as $horario)
                                @if($count % 3 == 0)
                                    <div class="row">
                                @endif
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="horario[]" id="horario{{ $horario->id }}" value="{{ $horario->id }}">
                                        <label class="form-check-label" for="horario{{ $horario->id }}">{{ $horario->horaini }}</label>
                                    </div>
                                </div>
                                @if($count % 3 == 2 || $loop->last)
                                    </div>
                                @endif
                                @php $count++; @endphp
                            @endforeach
                        </div>
                        <div id="horarioError" class="text-danger"></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <label for="fecha" class="form-label">Fecha de Reserva</label>
                        <div class="input-group">
                            <input type="text" id="fecha" name="fecha" class="form-control" placeholder="Seleccione una fecha" tabindex="4">
                            <button class="btn btn-outline-secondary" type="button" id="seleccionarFecha"><i class="far fa-calendar-alt"></i></button>
                        </div>
                        <div id="fechaError" class="text-danger"></div>
                    </div>
                </div>
                <!-- Resto del formulario -->
                <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
            </form>
        </div>
    </div>
@stop

@push('css')
<link rel="stylesheet" href="{{ asset('estilos/reserva.css') }}">
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function() {
        $('#materia').change(function() {
            var materiaNombre = $(this).val();
            if (materiaNombre) {
                $.ajax({
                    url: '{{ route("getGrupos") }}',
                    type: 'GET',
                    data: {
                        nombre_materia: materiaNombre
                    },
                    success: function(response) {
                        $('#grupo').empty();
                        $.each(response, function(id, grupo) {
                            $('#grupo').append('<option value="' + id + '">' + grupo + '</option>');
                        });
                    }
                });
            } else {
                $('#grupo').empty();
            }
        });
        $('#fecha').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        minDate: 0,
        position: {
            my: "right top",
            at: "right bottom"
        },
        prevText: 'Anterior',
        nextText: 'Siguiente'
    });

        $('#seleccionarFecha').click(function() {
            $('#fecha').datepicker('show');
        });
        $('form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    // Mostrar el mensaje de éxito
                    Swal.fire({
                        title: 'Solicitud enviada exitosamente',
                        text: '¡Gracias por enviar tu solicitud!',
                        icon: 'success',
                        timer: 1500, // Duración en milisegundos (1.5 segundos)
                        timerProgressBar: true,
                        showConfirmButton: false
                    }).then((result) => {
                        // Redirigir a la plantilla docente.blade.php
                        window.location.href = "docente";
                    });
                },
                error: function(xhr, status, error) {
                    // Manejar errores si es necesario
                }
            });
        });
    });
</script>

@endpush
