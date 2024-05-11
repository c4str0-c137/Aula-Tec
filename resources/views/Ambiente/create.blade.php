@extends('adminlte::page')

@section('title', 'CRUD AMBIENTES')

@section('content_header')
    <h1>Registro de ambientes</h1>
@stop

@section('content')
    <form action="/Ambiente" method="POST" id="ambienteForm">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="departamento" class="form-label">Departamento</label>
                    <input id="departamento" name="departamento" type="text" class="form-control" tabindex="1" maxlength="30">
                    <div id="departamentoError" class="text-danger"></div>
                </div>

                <div class="mb-3">
                    <label for="capacidad" class="form-label">Capacidad</label>
                    <input id="capacidad" name="capacidad" type="text" class="form-control" tabindex="2">
                    <div id="capacidadError" class="text-danger"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                 <label for="tipoAmbiente" class="form-label">Tipo de ambiente</label>
                  <select id="tipoAmbiente" name="tipoAmbiente" class="form-control" tabindex="2" required>
                   <option value="">Seleccione un tipo de ambiente</option>
                  @foreach($tipoambientes as $tipoAmbiente)
                    <option value="{{ $tipoAmbiente->id }}">{{ $tipoAmbiente->nombre }}</option>
                  @endforeach
               </select>
             <div id="tipoAmbienteError" class="text-danger"></div>
            </div>

                <div class="mb-3">
                    <label for="ubicacion" class="form-label">Ubicación</label>
                    <select id="ubicacion" name="ubicacion" class="form-control" tabindex="4">
                        <option value="">Seleccione una ubicación</option>
                        @foreach($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre }}</option>
                        @endforeach
                    </select>
                    <div id="ubicacionError" class="text-danger"></div>
                </div>
                </div>
                <div class="col-md-6">
                 <div class="mb-3">
                    <label for="numeroaula" class="form-label">Numero de aula</label>
                    <input id="numerodeaula" name="numeroaula" type="text" class="form-control" tabindex="1" maxlength="30">
                    <div id="numeroaulaError" class="text-danger"></div>
                 </div> 

                
            </div>
        </div>
        
        <div class="mb-3">
            <a href="/Ambiente" class="btn btn-secondary" tabindex="5">Cancelar</a>
            <button type="submit" class="btn btn-primary" id="guardarBtn" tabindex="6" disabled>Registrar</button>
        </div>
    </form>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            
            checkFormValidity();

            
            function checkFormValidity() {
                var departamento = $('#departamento').val();
                var capacidad = $('#capacidad').val();
                var tipo = $('#tipoAmbiente').val();
                var ubicacion = $('#ubicacion').val();

                // Validar que los campos no estén vacíos
                if (!departamento || !capacidad || !tipo || !ubicacion) {
                    $('#guardarBtn').prop('disabled', true);
                    return;
                }

                // Validar campo Departamento
                var departamentoRegex = /^[a-zA-Z0-9\s]*$/u;
                if (!departamentoRegex.test(departamento.trim()) && departamento.trim() !== '') {
                    $('#departamentoError').text('El campo tipo solo debe contener letras, números y espacios.');
                    $('#guardarBtn').prop('disabled', true);
                } else {
                    $('#departamentoError').text('');
                    if (departamento.trim().length < 4 || departamento.trim().length > 30) {
                    $('#guardarBtn').prop('disabled', true);
                    }
                }


                // Validar campo Capacidad
                if (isNaN(capacidad.trim()) || capacidad.trim() < 25 || capacidad.trim() > 120) {
                    $('#capacidadError').text('La capacidad debe estar entre 25 y 120.');
                    $('#guardarBtn').prop('disabled', true);
                } else {
                    $('#capacidadError').text('');
                    $('#guardarBtn').prop('disabled', false);
                }

                // Verificar si la capacidad es un número
                if (!$.isNumeric(capacidad.trim()) && capacidad.trim() !== '') {
                    $('#capacidadError').text('Solo se permiten caracteres numéricos.');
                    $('#guardarBtn').prop('disabled', true);
                } else {
                    $('#capacidadError').text('');
                }

               
            }

           
            $('#departamento, #capacidad, #tipo, #ubicacion').change(function() {
                checkFormValidity();
            });

            
            $('#ambienteForm').submit(function() {
                checkFormValidity();
                if ($('#guardarBtn').prop('disabled')) {
                    return false;
                }
                
                
                Swal.fire({
                    title: 'Registro exitoso!',
                    text: 'El ambiente ha sido registrado correctamente.',
                    icon: 'success',
                    timer: 3000, // Duración en milisegundos (3 segundos)
                    timerProgressBar: true,
                    showConfirmButton: false
                }).then((result) => {
                    // Redirigir al index de ambientes al cerrar la alerta
                    window.location.href = "/Ambiente";
                });
            });
        });
    </script>
@stop
