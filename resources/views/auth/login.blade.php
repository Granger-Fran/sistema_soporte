<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Iniciar sesión - Soporte Petorca</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            position: relative;
            background-color: #fef9c3;
        }
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: url('{{ asset('images/lt.png') }}') no-repeat center center;
            background-size: contain;
            opacity: 0.08;
            z-index: -1;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">

    <div class="max-w-md w-full bg-white border-4 border-[#12807b] rounded-xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-[#12807b] text-center mb-6">Bienvenido a Soporte </h2>

        @if(session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#12807b] focus:border-[#12807b]">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                <input id="password" type="password" name="password" required
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-[#12807b] focus:border-[#12807b]">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm">
                    <input type="checkbox" name="remember" class="rounded border-gray-300">
                    <span class="ml-2">Recordarme</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-[#12807b] hover:underline" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full bg-[#12807b] text-white py-2 rounded hover:bg-[#0e6b65] transition">
                Iniciar sesión
            </button>
        </form>
    </div>
</body>
</html>



