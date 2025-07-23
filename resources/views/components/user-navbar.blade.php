<div class="flex items-center gap-2 text-base font-semibold">

    {{-- 🏠 Botón Inicio --}}
    <a href="{{ route('user.home') }}"
       class="flex items-center gap-1 px-4 py-2 rounded transition duration-200 shadow-sm
              {{ request()->routeIs('user.home') 
                  ? 'bg-[#12807b] text-white' 
                  : 'bg-[#e5e5e5] text-gray-800 hover:bg-[#12807b] hover:text-white' }}">
        🏠 <span>Inicio</span>
    </a>

    {{-- 🎫 Botón Mis Tickets --}}
    <a href="{{ route('tickets.index') }}"
       class="flex items-center gap-1 px-4 py-2 rounded transition duration-200 shadow-sm
              {{ request()->routeIs('tickets.index') 
                  ? 'bg-[#12807b] text-white' 
                  : 'bg-[#e5e5e5] text-gray-800 hover:bg-[#12807b] hover:text-white' }}">
        🎫 <span>Mis Tickets</span>
    </a>

    {{-- 🚪 Botón Cerrar sesión --}}
    <form method="POST" action="{{ route('logout') }}" class="inline">
        @csrf
        <button type="submit"
                class="flex items-center gap-1 px-4 py-2 rounded transition duration-200 shadow-sm
                       bg-[#e5e5e5] text-gray-800 hover:bg-[#12807b] hover:text-white">
            🚪 <span>Cerrar sesión</span>
        </button>
    </form>

</div>

