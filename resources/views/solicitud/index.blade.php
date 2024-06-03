<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de reserva</title>
</head>
<body>
    @if (!empty($ambientes))
        <p>Hola {{ $reserva->docente }},</p>
        
        <p>Tu reserva ha sido confirmada con éxito. Aquí está la información de la reserva:</p>

        <ul>
            <li>Número de reserva: {{ $reserva->id }}</li>
            <li>Fecha y hora: {{ $reserva->fecha_reserva }}</li>
            <li>Grupo: {{ $reserva->grupo }}</li>
            <li>Materia: {{ $reserva->materia }}</li>
            <li>Motivo: {{ $reserva->acontecimiento }}</li>
            <li>Horario: {{ $reserva->horario }}</li>
            <li>Tipo Ambiente: {{ $reserva->tipo_ambiente }}</li>
            @foreach($ambientes as $ambiente)
            <li>Ambiente Disponible: {{ $ambiente }}</li>
            @endforeach
        </ul>
        
        <p>
            <a href="{{ route('docente.unica', ['reserva' => $reserva, 'ambientes' => $ambientes]) }}" class="btn btn-outlineprimary">
                Más Detalles
            </a>
        </p>




        <p>¡Gracias por usar nuestro sistema de reservas!</p>
    @else
        <p>No se encontraron ambientes disponibles para realizar la reserva.</p>
    @endif
</body>
</html>
