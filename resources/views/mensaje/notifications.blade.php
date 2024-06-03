<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
@extends('adminlte::page')

@section('title', 'Lista de Solicitudes')

@section('content_header')
<h1>Lista de Solicitudes</h1>
@stop

@section('content')
@if(session('message'))
<div id="sessionMessage" class="custom-success-message" style="display:none;">
    {{ session('message') }}
</div>
@endif
@if (auth()->user())
<div class="container">
    <div style="overflow-x: auto;">
        <table id="notificaciones" class="table table-striped table-bordered">
            <thead class="bg-primary text-white">
                <tr>
                    <th>ID</th>
                    <th>Docente</th>
                    <th>Materia</th>
                    <th>Motivo</th>
                    <th>Detalle</th>
                    <th style="display: none;">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservas as $reserva)
                <tr>
                    <td>{{  $reserva->id }}</td>
                    <td>{{  $reserva->docente }}</td>
                    <td>{{  $reserva->materia }}</td>
                    <td>{{  $reserva->acontecimiento }}</td>
                    <td>
                        <a href="{{route('mensaje.unico', ['id' => $reserva->id]) }}"
                            class="btn btn-outline-primary">Mas Detalles</a>
                    </td>
                    <td style="display: none;">{{ $reserva->fecha_reserva }}</td>

                </tr>
                @empty
                No tienes notificaciones
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
var table;
$(document).ready(function() {
    table = $('#notificaciones').DataTable({
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
        "pageLength": 10,
        "searching": true,
        "fixedHeader": true,
        "ordering": false
    });
});

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
    var sessionMessage = $('#sessionMessage').text().trim();
        if (sessionMessage) {
            Swal.fire({
                title: 'Mensaje',
                text: sessionMessage,
                html: '<i class="fa fa-envelope" style="font-size:48px;color:blue"></i><p>' + sessionMessage + '</p>',                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: false
            }).then((result) => {
                // Limpiar la variable de sesión
                $('#sessionMessage').text('');
            });
        }
});
</script>
@stop