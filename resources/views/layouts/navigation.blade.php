<nav x-data="{ open: false }"class="bg-gradient-to-r from-[#d3e4f0] to-[#b8d1e2] shadow-md border-b border-gray-200 text-white"
>
    <!-- Primary Navigation Menu -->
    <div class="w-full px-8 flex justify-between items-center h-20">
        <!-- Logo + título -->
        <div class="flex items-center gap-4">
            <!-- Logo centrado -->
            <img src="{{ asset('images/
lt.png') }}" alt="Municipalidad de Petorca" class="h-40 w-auto ml-10 drop-shadow-md">
            <!-- Título más grande y alineado al centro del logo -->
            <span class="text-white text-3xl font-bold tracking-wide"></span>
    
        </div>

        <!-- Settings Dropdown -->
        <div class="hidden sm:flex sm:items-center">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md text-white bg-[#37587a] hover:bg-[#2d4e6b] focus:outline-none transition">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ms-2">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link href="{{ route('profile.edit') }}">
                        {{ __('Mi Perfil') }}
                    </x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Cerrar sesión') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

        <!-- Botón hamburguesa (móvil) -->
        <div class="-me-2 flex items-center sm:hidden">
            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-[#2d4e6b] focus:outline-none transition">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</nav>

