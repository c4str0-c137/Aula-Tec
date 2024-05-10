<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
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
    <div style="overflow-x: auto; max-height: 400px;">
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
                    <th>Fecha de Creación</th>
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
                    <td>{{ $notification['created_at'] }}</td>
                </tr>
                @break {{-- Rompe el bucle después de encontrar la notificación --}}
                @endif
                @empty
                <tr>
                    <td colspan="14">No tienes notificaciones</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    @endif
</div>
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
var table;


function sendMarkRequest(id = null) {
    return $.ajax("{{ route('markNotification') }}", {
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            id
        }
    });
}

$(function() {
    $('.mark-as-read').click(function() {
        let notificationId = $(this).data('id'); // Obtener el ID de la notificación

        // Enviar la solicitud para marcar la notificación como leída
        let request = sendMarkRequest(notificationId);

        // Manejar la respuesta de la solicitud
        request.done(() => {
            // Eliminar el elemento de la interfaz una vez que la notificación se marca como leída
            $(this).parents('div.alert').remove();
        });
    });
});
</script>
@stop