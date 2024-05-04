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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Solicitudes</div>
                <div class="card-body">
                    <div class="row row-cols-2 row-cols-lg-4 g-2 g-lg-4">
                        @if (auth()->user())
                        @forelse ($notificationsData as $notification)
                        <div class="col">
                            <div class="alert alert-default-warning" style="width: 100%;">
                                <p>Docente: {{  $notification['Solicitante'] }}
                                <p>Motivo: {{  $notification['Motivo'] }}
                                <p>Fecha: {{  $notification['Fecha'] }}
                                <p>Horario: {{  $notification['Horario'] }}
                                <p>Grupo: {{  $notification['Grupo'] }}
                                <p>Materia: {{  $notification['Materia'] }}
                                <p>Capacidad: {{  $notification['capacidad'] }}
                                <p>{{ $notification['created_at']->diffForHumans() }}</p>
                                <form action="{{ route('markNotification') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $notification['id'] }}">
                                    <button type="submit" class="btn btn-sm btn-dark">Confirmar Reserva</button>
                                </form>
                            </div>
                        </div>

                        @empty
                        No tienes notificaciones
                        @endforelse

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
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
@endsection