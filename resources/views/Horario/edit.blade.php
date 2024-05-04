@extends('adminlte::page')

@section('title', 'Editar Ambiente y Horario')

@section('content_header')
    <h1>Editar Ambiente y Horario</h1>
@stop

@section('content')
    <form action="{{ route('Horario.update', $ambienteHorario->id) }}" method="POST" id="horarioForm">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="id_estado_horario" class="form-label">Estado</label>
                    <select id="id_estado_horario" name="id_estado_horario" class="form-control" tabindex="1" required>
                        <option value="">Seleccione un estado</option>
                         @foreach($estados as $estado)
                         <option value="{{ $estado->id }}" {{ $estado->id == $ambienteHorario->estado_horario->id ? 'selected' : '' }}>{{ $estado->estado }}</option>
                         @endforeach
                     </select>
                 </div>
           <div id="estadoError" class="text-danger"></div>
           <div class="mb-3">
           <label for="id_dia" class="form-label">Día</label>
            <select id="id_dia" name="id_dia" class="form-control" tabindex="2" required>
            <option value="">Seleccione un día</option>
                @foreach($dias as $dia)
               <option value="{{ $dia->id }}" {{ $dia->id == $ambienteHorario->dia->id ? 'selected' : '' }}>{{ $dia->nombre }}</option>
                @endforeach
                </select>
                 </div>
             </select>
                 <div id="diaError" class="text-danger"></div>
                  <div class="mb-3">
                    <label for="id_horario" class="form-label">Horario</label>
                    <select id="id_horario" name="id_horario" class="form-control" tabindex="3" required>
                       @foreach($horarios as $horario)
                          <option value="{{ $horario->id }}" {{ $horario->id == $ambienteHorario->horario->id ? 'selected' : '' }}>{{ $horario->horaini }}</option>
                       @endforeach
                     </select>
                  <div id="horarioError" class="text-danger"></div>
                </div>
                <div class="mb-3">
            <label for="id_ambiente" class="form-label">Ambiente</label>
             <select id="id_ambiente" name="id_ambiente" class="form-control" tabindex="4" required>
                   @foreach($ambientes as $ambiente)
                     <option value="{{ $ambiente->id }}" {{ $ambiente->id == $ambienteHorario->id_ambiente ? 'selected' : '' }}>{{ $ambiente->tipoDeAmbiente }}</option>
                    @endforeach
            </select>
          <div id="ambienteError" class="text-danger"></div>
       </div>
            </div>
        </div>
        
        <div class="mb-3">
            <a href="{{ route('ambiente_horarios.index') }}" class="btn btn-secondary" tabindex="5">Cancelar</a>
            <button type="submit" class="btn btn-primary" id="guardarBtn" tabindex="6">Actualizar</button>
        </div>
    </form>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            $('#horarioForm').submit(function(event) {
                event.preventDefault();

                // Realizar la solicitud AJAX para enviar el formulario
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function(response) {
                        // Mostrar el mensaje de éxito
                        Swal.fire({
                            title: 'Actualización exitosa!',
                            text: 'Los cambios se han guardado correctamente.',
                            icon: 'success',
                            timer: 1500, // Duración en milisegundos (3 segundos)
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then(() => {
                            // Redireccionar a la página de inicio después de cerrar la alerta
                            window.location.href = "{{ route('ambiente_horarios.index') }}";
                        });
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log(xhr.responseText); // Mostrar error en la consola para depuración
                        // Manejar el error de acuerdo a tus necesidades
                    }
                });
            });
        });
    </script>
@stop
