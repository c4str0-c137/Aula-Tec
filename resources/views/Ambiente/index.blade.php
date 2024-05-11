@extends('adminlte::page')

@section('title', 'CRUD')

@section('content_header')
    <h1>Listado de ambientes</h1>
@stop

@section('content')
    @if(Auth::check() && Auth::user()->id_rol === 1)
        <a href="Ambiente/create" class="btn btn-primary mb-3">CREAR</a>
        <table id="ambiente" class="table table-striped table-bordered shadow-lg mt-4" style="width:100%"> 
            <thead class="bg-primary text-white">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Departamento</th>
                    <th scope="col">Capacidad</th>
                    <th scope="col">Tipo de ambiente</th>
                    <!-- <th scope="col">Estado</th> -->
                    <th scope="col">Ubicacion</th>
                    <th scope="col">Numero de aula</th>

                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ambientes as $ambiente)
                    <tr>
                        <td>{{$ambiente->id}}</td>
                        <td>{{$ambiente->departamento}}</td>
                        <td>{{$ambiente->capacidad}}</td>
                        
                        <td>{{ $ambiente->tipoAmbiente->nombre ?? 'N/A' }}</td>
                        <td>{{ $ambiente->ubicacion->nombre}}</td>
                        <td>{{ $ambiente->numeroaula}}</td>


                        
                        <td>
                            <form action="{{ route ('Ambiente.destroy', $ambiente->id)}}" method="POST">
                            <a href="/Ambiente/{{ $ambiente->id}}/edit" class = "btn btn-info">Editar</a>
                            <!-- <a href="{{ route('Ambiente.edit', $ambiente->id) }}" class="btn btn-info">Editar</a> -->

                            @csrf
                            @method('DELETE')
                            <button type="submit" class = "btn btn-danger">Borrar</button>
                            </form>
                        </td> 
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@stop

@section('css')
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#ambiente').DataTable({
                "language": {
                    "search": '<span class="fa fa-search"></span>', // Cambiar el texto por un icono
                    "lengthMenu": "",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrando de un total de _MAX_ registros)",
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Siguiente"
                    }
                },
                "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>><"row"<"col-sm-12"tr>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                "lengthMenu": [5, 10, 25, 50, 100], 
                 "pageLength": 6
            });
        });
    </script>
@stop
