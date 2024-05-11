@extends('adminlte::page')

@section('title', 'Lista de Solicitudes')

@section('content_header')
    <h1>Lista de Solicitudes</h1>
@stop

@section('content')
    @if(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    @if (auth()->user())
        <div class="container">
            <div style="overflow-x: auto;">
                <table id="notificaciones" class="table table-striped table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Docente</th> 
                            <th>Materia</th>
                            <th>Grupo</th>
                            <th>Capacidad</th>
                            <th>Motivo</th>
                            <th>Horario</th>
                            <th>Fecha</th>
                            <th>Tipo Ambiente</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notificationsData as $notification)
                            @if ($notification['id'] == $notificationId)
                                <tr>
                                    <td>{{ $notification['Solicitante'] }}</td>
                                    <td>{{ $notification['Materia'] }}</td>
                                    <td>{{ $notification['Grupo'] }}</td>
                                    <td>{{ $notification['capacidad'] }}</td>
                                    <td>{{ $notification['Motivo'] }}</td>
                                    <td>{{ $notification['Horario'] }}</td>
                                    <td>{{ $notification['Fecha'] }}</td>
                                    <td>{{ $notification['ambiente'] }}</td>
                                    <td>
                                        <button class="btn btn-info assign-btn" data-capacidad="{{ $notification['capacidad'] }}">Asignar</button>
                                    </td>
                                </tr>
                                @break {{-- Rompe el bucle después de encontrar la notificación --}}
                            @endif
                        @empty
                            <tr>
                                <td colspan="9">No tienes notificaciones</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection

@section('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.0/css/fixedHeader.dataTables.min.css">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.0/js/dataTables.fixedHeader.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#notificaciones').DataTable({
                "language": {
                    "search": '<span class="fa fa-search"></span>', // Cambiar el texto por un icono
                    "lengthMenu": "",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrando de un total de MAX registros)",
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Siguiente"
                    }
                },
                "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>><"row"<"col-sm-12"tr>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                "pageLength": 3,
                "searching": true,
                "fixedHeader": true
            });

            // Manejo del clic en el botón "Asignar"
            $('.assign-btn').click(function() {
                // Obtener la capacidad desde el atributo data-capacidad del botón
                let capacidad = $(this).data('capacidad');
                
                // Imprimir la capacidad en la consola
                console.log("Capacidad:", capacidad);

                // Realizar la solicitud AJAX para obtener los ambientes con la misma capacidad
                $.ajax({
                    url: '{{ route("buscarAmbientes") }}',
                    method: 'POST',
                    data: { capacidad: capacidad },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(response) {
                        console.log("Ambientes con capacidad", capacidad, ":", response);
                        // Aquí puedes manipular los datos de los ambientes obtenidos, como agregarlos a la interfaz de usuario, etc.
                    },
                    error: function(xhr, status, error) {
                        console.error("Error al buscar ambientes:", error);
                    }
                });
            });
        });
    </script>
@stop
