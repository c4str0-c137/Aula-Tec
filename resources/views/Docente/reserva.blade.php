@extends('adminlte::page')

@section('title', 'Solicitud de Reserva')

@section('content_header')
    <h1>Solicitud de Reserva</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('guardar_solicitud') }}" method="POST" id="solicitudForm">
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
                    <div class="col-md-6">
                        <label for="tipo_ambiente" class="form-label">Tipo de Ambiente</label>
                        <select id="tipo_ambiente" name="tipo_ambiente" class="form-control" tabindex="4">
                            <option value="">Seleccione el tipo de ambiente</option>
                            @foreach($tiposAmbiente as $tipoAmbiente)
                                <option value="{{ $tipoAmbiente->id }}">{{ $tipoAmbiente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col position-relative">
                        <label for="materia" class="form-label">Materias</label>
                        <select id="materia" name="materia" class="form-control" tabindex="4">
                            <option value="">Seleccione una Materia</option>
                            @foreach($materias as $materia)
                                <option value="{{ $materia }}">{{ $materia }}</option>
                            @endforeach
                        </select>
                        <div id="materiaError" class="error-message position-absolute bg-danger text-white py-2 px-3 rounded" style="display: none; z-index: 100; top: 100%; left: 0; right: 0;">
                            <i class="fas fa-exclamation-circle me-2"></i>Por favor, seleccione una materia
                        </div>
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
                    <div class="col position-relative">
                        <label for="capacidad" class="form-label">Capacidad</label>
                        <input type="text" id="capacidad" name="capacidad" class="form-control" placeholder="Ingrese la cantidad de alumnos para su ambiente" tabindex="4">
                        <div id="capacidadError" class="error-message position-absolute bg-danger text-white py-2 px-3 rounded" style="display: none; z-index: 100; top: 100%; left: 0; right: 0;">
                            <i class="fas fa-exclamation-circle me-2"></i>Ingrese un valor entero entre 1 y 200
                        </div>
                    </div>
                    <div class="col-6 position-relative">
                        <label for="motivo" class="form-label">Motivo de Reserva</label>
                        <select id="motivo" name="motivo" class="form-control" tabindex="4">
                            <option value="">Seleccione un Motivo</option>
                            @foreach($acontecimientos as $acontecimiento)
                                <option value="{{ $acontecimiento->id }}">{{ $acontecimiento->tipo }}</option>
                            @endforeach
                        </select>
                        <div id="acontecimientoError" class="error-message position-absolute bg-danger text-white py-2 px-3 rounded" style="display: none; z-index: 100; top: 100%; left: 0; right: 0;">
                            <i class="fas fa-exclamation-circle me-2"></i>Seleccione el motivo para su reserva
                        </div>
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
                        <div id="horarioError" class="error-message position-absolute bg-danger text-white py-2 px-3 rounded" style="display: none; z-index: 100; top: 100%; left: 0; right: 0;">
                            <i class="fas fa-exclamation-circle me-2"></i>Seleccione un horario <!-- Mensaje de error -->
                        </div>
                    </div>
                </div>
                 
                <div class="mb-3 row">
                    <div class="col position-relative">
                        <label for="fecha" class="form-label">Fecha de Reserva</label>
                        <div class="input-group">
                            <input type="text" id="fecha" name="fecha" class="form-control" placeholder="Seleccione una fecha" tabindex="4">
                            <button class="btn btn-outline-secondary" type="button" id="seleccionarFecha"><i class="far fa-calendar-alt"></i></button>
                        </div>
                        <div id="fechaError" class="error-message position-absolute bg-danger text-white py-2 px-3 rounded" style="display: none; z-index: 100; top: 100%; left: 0; right: 0;">
                            <i class="fas fa-exclamation-circle me-2"></i>Por favor, Elija una fecha
                        </div>
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

        $.datepicker.setDefaults($.datepicker.regional['es']);
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
            nextText: 'Siguiente',
            defaultDate: new Date(),
            beforeShowDay: function(date) {
                var today = new Date();
                if (date.getDate() === today.getDate() && date.getMonth() === today.getMonth() && date.getFullYear() === today.getFullYear()) {
                    return [true, 'current-day', 'Día actual'];
                }
                return [true, '', ''];
            },
            onSelect: function(selectedDate) {
                $('#fechaError').fadeOut('slow');
            },
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb']
        });

        $('#seleccionarFecha').click(function() {
            $('#fecha').datepicker('show');
        });

        $('#solicitudForm').submit(function(e) {
            e.preventDefault();
            var materiaSeleccionada = $('#materia').val();
            if (!materiaSeleccionada) {
                $('#materiaError').text('Por favor, seleccione una materia').show();
                setTimeout(function() {
                    $('#materiaError').fadeOut('slow');
                }, 3000);
                return;
            }
            var capacidad = $('#capacidad').val();
            if (!(/^\d+$/.test(capacidad))) {
                $('#capacidadError').text('Ingrese un valor entero entre 1 y 200').show();
                setTimeout(function() {
                    $('#capacidadError').fadeOut('slow');
                }, 3000);
                return;
            }
            capacidad = parseInt(capacidad);
            if (capacidad < 1 || capacidad > 200) {
                $('#capacidadError').text('Ingrese un valor entero entre 1 y 200').show();
                setTimeout(function() {
                    $('#capacidadError').fadeOut('slow');
                }, 3000);
                return;
            }
            var motivoSeleccionado = $('#motivo').val();
            if (!motivoSeleccionado) {
                $('#acontecimientoError').text('Seleccione el motivo para su reserva').show();
                setTimeout(function() {
                    $('#acontecimientoError').fadeOut('slow');
                }, 3000);
                return;
            }
            var horarioSeleccionado = $("input[name='horario[]']:checked").length;
            if (horarioSeleccionado === 0) {
                $('#horarioError').text('Por favor Seleccione un al menos horario').show();
                setTimeout(function() {
                    $('#horarioError').fadeOut('slow');
                }, 3000);
                return;
            }
            var fechaSeleccionada = $('#fecha').val();
            if (!fechaSeleccionada) {
                $('#fechaError').text('Por favor, Elija una fecha').show();
                setTimeout(function() {
                    $('#fechaError').fadeOut('slow');
                }, 3000);
                return;
            }
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    Swal.fire({
                        title: 'Solicitud enviada exitosamente',
                        text: '¡Gracias por enviar tu solicitud!',
                        icon: 'success',
                        timer: 1500,
                        timerProgressBar: true,
                        showConfirmButton: false
                    }).then((result) => {
                        window.location.href = "docente";
                    });
                },
                error: function(xhr, status, error) {
                }
            });
        });
    });

</script>
@endpush
