<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('img/icono.ico') }}">

    <!-- Estilos de bootstrap -->

    <!-- Estilos css generales -->
    <link href="{{ asset('css/base/css/general.css') }}" rel="stylesheet">
    <link href="{{ asset('css/base/css/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/base/css/footer.css') }}" rel="stylesheet">

    <!-- Estilos cambiantes -->

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title></title>
</head>

<body>

    <div class="content">
        <!-- Incluir menú -->

        <section class="section">
           
        </section>

        <!-- Incluir footer -->
    </div>

    <!-- Scripts de bootstrap -->
</body>

</html>