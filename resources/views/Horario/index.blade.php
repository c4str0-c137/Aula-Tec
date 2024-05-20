<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
@extends('adminlte::page')

@section('title', 'Listado de ambiente_horarios')

@section('content_header')
    <h1>Listado de ambientes y horarios</h1>
@stop

@section('content')
    @if(Auth::check() && Auth::user()->id_rol === 1)
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('Horario.create') }}" class="btn btn-primary mb-3">CREAR</a>
                </div>
            </div>
            <h2>Filtros</h2>
            <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
                <div class="col">
                    <div class="btn-group-vertical dropright" style="width: 100%;">
                        <button type="button" class="btn btn-primary dropdown-toggle btn-block" data-toggle="dropdown">
                            <i class="bi-building"> Departamentos </i> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu" id="departamento_filter">
                            <li data-val="">
                                <span class="dropdown-item"><i class="bi-building">Departamentos</i></span>
                            </li>
                            @foreach($departamentos as $departamento)
                                <li data-val="{{ $departamento }}">
                                    <span class="dropdown-item"><i class="bi-building">{{ $departamento }}</i></span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="btn-group-vertical dropright" style="width: 100%;">
                        <button type="button" class="btn btn-outline-success dropdown-toggle btn-block"
                                data-toggle="dropdown">
                            <i class="bi-house">Todas las Aulas </i><span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu" id="aula_filter">
                            <li data-val="">
                                <span class="dropdown-item"><i class="bi-house">Todas las Aulas</i></span>
                            </li>
                            @foreach($ambientes as $ambiente)
                                <li data-val="{{ $ambiente->numeroaula }}">
                                    <span class="dropdown-item"><i class="bi-house">{{ $ambiente->numeroaula }}</i></span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="btn-group-vertical dropright" style="width: 100%;">
                        <button type="button" class="btn btn-outline-info dropdown-toggle btn-block" data-toggle="dropdown">
                            <i class="bi-calendar">Todas los Dias</i> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu" id="dias_filter">
                            <li data-val="">
                                <span class="dropdown-item"><i class="bi-calendar">Todas los Dias</i></span>
                            </li>
                            @foreach($dias as $dia)
                                <li data-val="{{ $dia->nombre }}">
                                    <span class="dropdown-item"><i class="bi-calendar">{{ $dia->nombre}}</i></span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="btn-group-vertical dropright" style="width: 100%;">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle btn-block"
                                data-toggle="dropdown">
                            <i class="bi-clock">Todos los Horarios</i> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu" id="horario_filter">
                            <li data-val="">
                                <span class="dropdown-item"><i class="bi-clock">Todos los Horarios</i></span>
                            </li>
                            @foreach($horarios as $horario)
                                <li data-val="{{ $horario->horaini }}">
                                    <span class="dropdown-item"><i class="bi-clock">{{ $horario->horaini }}</i></span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div style="overflow-x: auto;">
                <table id="ambienteHorariosTable" class="table table-striped table-bordered">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Departamento</th>
                        <th>Ambiente</th>
                        <th>Numero de aula</th>
                        <th>Día</th>
                        <th>Horario Reserva</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($ambienteHorarios as $ambienteHorario)
                        <tr>
                            <td>{{ $ambienteHorario->id }}</td>
                            <td>{{ $ambienteHorario->ambiente->departamento }}</td>
                            <td>{{ $ambienteHorario->ambiente->tipoAmbiente->nombre}}</td>
                            <td>{{ $ambienteHorario->ambiente->numeroaula }}</td>
                            <td>{{ $ambienteHorario->dia->nombre}}</td>
                            <td>{{ $ambienteHorario->horario->horaini }}</td>
                           
                            <td>{{ $ambienteHorario->estado_horario->estado}}</td>
                            <td>
                                <form action="{{ route ('Horario.destroy', $ambienteHorario->id)}}" method="POST">
                                    <a href="/Horario/{{ $ambienteHorario->id}}/edit" class = "btn btn-info">Editar</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class = "btn btn-danger">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@stop

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
        var table;
        $(document).ready(function() {
            table = $('#ambienteHorariosTable').DataTable({
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

            // Controladores de eventos para los filtros
            $('#departamento_filter .dropdown-item').on('click', function() {
                var selectedValue = $(this).parent().attr('data-val');
                var selectedText = $(this).text();
                $(this).closest('.btn-group-vertical').find('.btn-primary').html('<i class="bi-building">' +
                    selectedText + ' </i><span class="caret"></span>');
                table.column(1).search(selectedValue).draw();
            });

            $('#aula_filter .dropdown-item').on('click', function() {
                var selectedValue = $(this).parent().attr('data-val');
                var selectedText = $(this).text();
                $(this).closest('.btn-group-vertical').find('.btn-outline-success').html(
                    '<i class="bi-house">' + selectedText + ' </i><span class="caret"></span>');
                table.column(3).search(selectedValue).draw();
            });

            $('#dias_filter .dropdown-item').on('click', function() {
                var selectedValue = $(this).parent().attr('data-val');
                var selectedText = $(this).text();
                $(this).closest('.btn-group-vertical').find('.btn-outline-info').html(
                    '<i class="bi-calendar">' + selectedText + ' </i><span class="caret"></span>');
                table.column(4).search(selectedValue).draw();
            });

            $('#horario_filter .dropdown-item').on('click', function() {
                var selectedValue = $(this).parent().attr('data-val');
                var selectedText = $(this).text();
                $(this).closest('.btn-group-vertical').find('.btn-outline-primary').html(
                    '<i class="bi-clock">' + selectedText + ' <span class="caret"></span>');
                table.column(5).search(selectedValue).draw();
            });
        });
    </script>
@stop