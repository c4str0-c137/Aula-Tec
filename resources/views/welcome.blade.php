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
            background-color: black; 
            color: white; 
            margin: 0; 
            padding: 0; 
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
    </style>
</head>
<body class="antialiased" style="background-color: #424858;">
<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline login-button">Iniciar sesión</a>
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
            <svg viewBox="0 0 651 192" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-16 w-auto text-gray-700 sm:h-20">
                <g clip-path="url(#clip0)" fill="#EF3B2D">
                    <path d="M248.032 44.676h-16.466v100.23h47.394v-14.748h-30.928V44.676zM337.091 87.202c-2.101-3.341-5.083-5.965-8.949-7.875-3.865-1.909-7.756-2.864-11.669-2.864-5.062 0-9.69.931-13.89 2.792-4.201 1.861-7.804 4.417-10.811 7.661-3.007 3.246-5.347 6.993-7.016 11.239-1.672 4.249-2.506 8.713-2.506 13.389 0 4.774.834 9.26 2.506 13.459 1.669 4.202 4.009 7.925 7.016 11.169 3.007 3.246 
            </svg>
        </div>
    </div>
</div>
<div style="text-align: center; margin-top: 50px;">
    <h2>Facultad de Ciencias y tecnologia</h2>
    
</div>
</body>
</html>