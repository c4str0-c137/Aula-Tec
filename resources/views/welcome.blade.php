<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            color: white; 
            margin: 0; 
            padding: 0; 
            background-image: url('{{ asset('img/fondo.jpg') }}');
            background-size: cover; 
            background-repeat: no-repeat;
            background-position: center center;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }
        .login-button {
            background-color: #3862D8; 
            color: white; 
            padding: 8px 16px; 
            border-radius: 4px; 
            text-decoration: none;
            margin-top: 20px; 
            margin-right: 20px; 
            position: fixed; 
            top: 20px; 
            right: 20px; 
        }
        .footer-text {
            position: absolute; 
            bottom: 20px; 
            left: 20px; 
            margin: 0; 
        }
        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 200px;
            height: auto;
        }
    </style>
</head>
<body class="antialiased">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline login-button">Iniciar sesión</a>
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                
            </div>
        </div>
    </div>
    <div class="footer-text">
        <h2>Facultad de Ciencias y Tecnología</h2>
    </div>
    <img src="{{ asset('img/logoAulatec.jpg') }}" alt="Logo Aulatec" class="logo">
</body>
</html>
