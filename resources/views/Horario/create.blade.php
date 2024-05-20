@extends('adminlte::page')

@section('title', 'CRUD HORARIOS')

@section('content_header')
    <h1>Registro de Horas y Ambientes</h1>
@stop

@section('content')
    <form action="{{ route('ambiente_horarios.store') }}" method="POST" id="horarioForm">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="id_estado_horario" class="form-label">Estado</label>
                    <select id="id_estado_horario" name="id_estado_horario" class="form-control" tabindex="1" required>
                        <option value="">Seleccione un estado</option>
                        @foreach($estados as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->estado }}</option>
                        @endforeach
                    </select>
                    <div id="estadoError" class="text-danger"></div>
                </div>
                <div class="mb-3">
                     <label for="id_dia" class="form-label">Día</label>
                     <select id="id_dia" name="id_dia" class="form-control" tabindex="2" required>
                       <option value="">Seleccione un día</option>
                         @foreach($dias as $dia)
                      <option value="{{ $dia->id }}">{{ $dia->nombre }}</option>
                         @endforeach
                    </select>
                <div id="diaError" class="text-danger"></div>
              </div>

              <div class="mb-3">
                <label for="id_horario" class="form-label">Horario</label>
                  <div class="checkbox-grid"> 
        @foreach($horarios as $horario)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="id_horario[]" id="horario{{ $horario->id }}" value="{{ $horario->id }}">
            <label class="form-check-label" for="horario{{ $horario->id }}">{{ $horario->horaini }}</label>
        </div>
        @endforeach
    </div>
    <div id="horarioError" class="text-danger"></div>
</div>

                
                <div class="mb-3">
                    <label for="id_ambiente" class="form-label">Tipo de Ambiente</label>
                    <select id="id_ambiente" name="id_ambiente" class="form-control" tabindex="4" required>
                        <option value="">Seleccione un ambiente</option>
                        @foreach($ambientes as $ambiente)
                            <option value="{{ $ambiente->id }}">{{ $ambiente->tipoAmbiente->nombre }}</option>
                        @endforeach
                    </select>
                    <div id="ambienteError" class="text-danger"></div>
                </div>
            </div>
        </div>
        
        <div class="mb-3">
            <a href="{{ route('ambiente_horarios.index') }}" class="btn btn-secondary" tabindex="5">Cancelar</a>
            <button type="submit" class="btn btn-primary" id="guardarBtn" tabindex="6">Registrar</button>
        </div>
    </form>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}

    @section('css')
    <style>
        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); /* Cambia el ancho de las columnas según sea necesario */
            gap: 10px; /* Espacio entre las casillas de verificación */
        }

        .checkbox-grid .form-check {
            margin-bottom: 0; /* Elimina el margen inferior predeterminado */
        }
    </style>
@stop

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
       $(document).ready(function() {
    $('#horarioForm').submit(function(event) {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Registro exitoso!',
                        text: 'El horario y ambiente han sido registrados correctamente.',
                        icon: 'success',
                        timer: 2000, // Duración en milisegundos (2 segundos)
                        timerProgressBar: true,
                        showConfirmButton: false
                    }).then((result) => {
                        window.location.href = "/Horario";
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON;
                    $('#horarioError').text(errors.error);
                } else {
                    $('#horarioError').text('');
                }
                Swal.fire({
                    title: 'Error!',
                    text: 'Ya existe un registro con el mismo día y horario.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: true
                }).then((result) => {
                    window.location.href = "/Horario";
                });
            }
        });
    });
});


    </script>
@stop
