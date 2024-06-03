{{-- Vista --}}
@extends('adminlte::page')

@section('title', 'Lista de Solicitudes')

@section('content_header')
    <h1>Lista de Solicitudes</h1>
@stop

@section('content')
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
                        @forelse ($reservas as $reserva)
                            @if ($reserva->id == $id)
                                <tr>
                                    <td>{{ $reserva->docente }}</td>
                                    <td>{{ $reserva->materia  }}</td>
                                    <td>{{ $reserva->grupo  }}</td>
                                    <td>{{ $reserva->capacidad  }}</td>
                                    <td>{{ $reserva->acontecimiento  }}</td>
                                    <td>{{ $reserva->horario  }}</td>
                                    <td>{{ $reserva->fecha_reserva  }}</td>
                                    <td>{{ $reserva->tipo_ambiente  }}</td>
                                    <td>
                                        <form action="{{ route('asignarAmbiente', ['id' => $reserva->id]) }}" method="GET" id="solicitudForm">
                                            @csrf
                                            <input type="hidden" name="capacidad" value="{{ $reserva->capacidad }}">
                                            <input type="hidden" name="tipo_ambiente" value="{{ $reserva->tipo_ambiente }}">
                                            <input type="hidden" name="horario" value="{{ $reserva->horario }}">
                                            <button type="submit" class="btn btn-info assign-btn">Asignar</button>
                                        </form>
                                    </td>
                                </tr>
                                @break 
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
        });
    </script>
@stop
