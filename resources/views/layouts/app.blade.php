<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'Soporte Petorca') }}</title>

    <!-- ✅ Fuentes y estilos -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- ✅ SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ✅ Estilos y scripts compilados por Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

</script>
<body x-data class="font-sans antialiased bg-[#f2f2f2] text-gray-900">



    <!-- ✅ Contenedor principal en pantalla completa -->
    <div class="flex min-h-screen">

        {{-- 🚫 Sidebar personalizado (puedes activarlo aquí si se usa en el futuro) --}}

        <!-- ✅ Área derecha de contenido -->
        <div class="flex-1 flex flex-col">

            <!-- ✅ Encabezado con logo + menú + perfil -->
         <header x-data="{ openMenu: false }" class="fixed top-0 left-0 w-full bg-white border-b shadow-sm px-4 md:px-12 py-0 flex items-center justify-between z-50">

    <!-- LOGO + TÍTULO -->
    <div class="flex items-center gap-2 md:gap-4">
        <img src="{{ asset('images/lt.png') }}" alt="Logo" class="h-14 md:h-28 w-auto" />
        <span class="text-lg md:text-3xl font-bold text-[#12807b] hidden md:inline">Soporte</span>
    </div>

    <!-- BOTÓN HAMBURGUESA SOLO EN MOBILE / TABLET -->
    <button @click="openMenu = !openMenu" class="md:hidden text-[#12807b] focus:outline-none">
        <svg x-show="!openMenu" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg x-show="openMenu" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- MENÚ COMPLETO -->
    <nav :class="{'hidden': !openMenu}" class="absolute md:static top-full left-0 w-full md:w-auto bg-white md:bg-transparent shadow-md md:shadow-none border-t md:border-0 px-4 md:px-0 py-4 md:py-0 flex-col md:flex md:flex-row md:items-center md:gap-6 z-50">
        
        <!-- CAMPANA -->
        <div class="relative mb-4 md:mb-0">
            <a href="{{ route('tickets.index') }}" class="inline-block">
                <svg class="w-6 md:w-8 h-6 md:h-8 text-[#12807b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V9a6 6 0 10-12 0v5c0 .386-.14.735-.395 1.02L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                @if($notificationsCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-2 py-0.5">
                        {{ $notificationsCount }}
                    </span>
                @endif
            </a>
        </div>

        {{-- MENÚ DE NAVEGACIÓN --}}
        <div class="flex flex-col md:flex-row md:gap-6 items-start md:items-center space-y-2 md:space-y-0">
            @include('components.user-navbar')
        </div>

        <!-- SALUDO -->
        <div x-data="{ openModal: false }" @keydown.escape.window="openModal = false" class="mt-4 md:mt-0">
            <button @click="openModal = true"
                    class="flex items-center gap-2 text-[#37587a] font-semibold text-base md:text-lg bg-white/50 px-3 md:px-4 py-1.5 md:py-2 rounded-xl shadow-sm border border-gray-200 hover:bg-[#e0edf5] transition w-full md:w-auto">
                <span class="text-xl md:text-2xl">👋</span>
                <span>Hola, {{ Auth::user()->name }}</span>
            </button>

            <!-- MODAL -->
            <template x-if="openModal">
                <div
                    @click="openModal = false"
                    class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">

                    <div
                        @click.stop
                        class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md"
                        x-transition:enter="transition transform ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition transform ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95">

                        <h2 class="text-xl font-bold mb-4 text-[#37587a]">👤 Datos del Usuario</h2>
                        <ul class="space-y-2 text-gray-700">
                            <li><strong>Nombre:</strong> {{ Auth::user()->name }}</li>
                            <li><strong>Apellido:</strong> {{ Auth::user()->last_name }}</li>
                            <li><strong>Email:</strong> {{ Auth::user()->email }}</li>
                            <li><strong>Teléfono:</strong> {{ Auth::user()->phone }}</li>
                            <li><strong>Rol:</strong> {{ Auth::user()->role }}</li>
                            <li><strong>Departamento:</strong> {{ Auth::user()->department }}</li>
                        </ul>
                        <div class="mt-6 text-right">
                            <button @click="openModal = false"
                                    class="bg-[#37587a] hover:bg-[#2d4e6b] text-white font-semibold px-4 py-2 rounded">
                                Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </nav>
</header>





            <!-- 📦 Contenido dinámico de cada vista -->
            <main class="mt-24 flex-1 px-6 py-8">
                @yield('content')
            </main>

        </div>
        <!-- 🔚 Fin del contenido principal -->
    </div>
    <!-- 🔚 Fin del contenedor general -->

</body>
</html>
