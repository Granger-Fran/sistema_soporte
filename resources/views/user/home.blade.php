@extends('layouts.app')
{{-- Extiende el layout general de la app. Aquí se carga la base visual común: header, scripts, etc. --}}

@section('content')

<!-- 📦 Contenedor principal que ocupa toda la altura de la pantalla -->
<style>
    body {
        background: linear-gradient(to bottom, #fecf40, #ffffff);
    }
</style>

{{-- ✅ ALERTA DE ÉXITO (SweetAlert) al inicio para cargar de inmediato si existe --}}
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Ticket enviado',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });
    </script>
@endif

{{-- 🧾 CONTENIDO PRINCIPAL --}}
<main class="sm-2 flex-1 flex flex-col items-center justify-start px-4 sm:px-6 md:px-8 py-8 sm:py-10">

    <div class="flex flex-col md:flex-row justify-center items-start gap-6 md:gap-10 w-full max-w-4xl px-4 sm:px-6 lg:px-0.5">

        <!-- COLUMNA IZQUIERDA: Imagen + Botón -->
        <div class="w-full md:basis-2/5 lg:basis-1/3 flex flex-col items-center space-y-2 text-start">
            <!-- IMAGEN -->
            <div id="lottie-tech" class="w-[180px] sm:w-[220px] md:w-[300px] lg:w-[380px] h-[180px] sm:h-[240px] md:h-[300px] lg:h-[380px] mx-auto"></div>

            <!-- BOTÓN -->
            <a href="{{ route('tickets.create') }}"
               class="bg-[#12807b] text-white text-lg sm:text-xl font-bold px-8 sm:px-10 py-3 sm:py-4 rounded-full shadow-lg
                      hover:bg-[#0f6a69] transition duration-300 ease-in-out transform hover:scale-105">
               Ingreso de Ticket
            </a>
        </div>

        <!-- COLUMNA DERECHA: Noticias -->
        <div class="w-full md:basis-3/5 lg:basis-2/3">
            <div class="bg-[#FFFBE6] border border-[#f7e4a3] rounded-xl shadow-lg p-4 sm:p-6 mt-6 md:mt-0 w-full text-left max-w-full">

                <h2 class="text-xl sm:text-2xl font-bold text-[#12807b] mb-4 flex items-center gap-2">
                    📰 Noticias y Avisos
                </h2>

                @if($notices->count())
                    <div class="space-y-4 sm:space-y-6 overflow-y-auto max-h-[32rem] px-2">
                        @foreach($notices as $notice)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3 sm:p-4 shadow-sm">
                                @if($notice->created_at)
                                    <p class="text-xs sm:text-sm text-gray-600 mb-2">
                                        📅 Publicado el {{ $notice->created_at->format('d/m/Y') }}
                                    </p>
                                @endif

                                @if($notice->title)
                                    <h3 class="text-base sm:text-lg font-semibold text-[#12807b] mb-2">
                                        {{ $notice->title }}
                                    </h3>
                                @endif

                                @if($notice->content)
                                    <p class="text-gray-800 mb-2">
                                        {{ $notice->content }}
                                    </p>
                                @endif

                                @if($notice->image_url)
                                    <img src="{{ $notice->image_url }}" alt="Imagen de noticia" class="mt-2 rounded shadow max-w-full h-auto">
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-sm">No hay noticias disponibles en este momento.</p>
                @endif
            </div>
        </div>
    </div>
</main>

{{-- ✅ SCRIPT de Lottie --}}
<script src="https://unpkg.com/lottie-web@5.10.0/build/player/lottie.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        lottie.loadAnimation({
            container: document.getElementById('lottie-tech'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset("animations/tecnico1.json") }}'
        });
    });
</script>

<!-- 🤖 SCRIPT del chatbot -->
<script src="{{ asset('js/filament/chatbot.js') }}"></script>

<!-- 💬 BOTÓN FLOTANTE del chatbot (corregido el error de doble <) -->
<div id="chatbot-button"
     class="fixed bottom-6 right-6 bg-white hover:bg-gray-100 p-6 rounded-full shadow-xl z-50 cursor-pointer animate-bounce flex items-center justify-center w-24 h-24 transition">
    <img src="{{ asset('images/robot.png') }}" alt="Chatbot" class="w-18 h-18">
</div>

<!-- 🪟 VENTANA EMERGENTE del chatbot -->
<div id="chatbot-container"
     class="fixed bottom-24 right-6 w-80 bg-white rounded-2xl shadow-2xl p-4 hidden z-50 border border-[#12807b] transition-all duration-300 flex flex-col max-h-[36rem]">
    <div class="flex justify-between items-center mb-4 rounded-t-xl bg-[#12807b] px-4 py-3 text-white shadow">
        <h2 class="text-lg font-bold flex items-center gap-2">
            🤖 ¿Necesitas ayuda?
        </h2>
        <button onclick="cerrarChatbot()" class="text-white hover:text-red-300 text-xl font-bold">&times;</button>
    </div>

    <div id="chat" class="flex flex-col gap-3 overflow-y-auto text-sm scroll-smooth pr-2 mb-4 max-h-64 bg-white rounded-b-xl p-3 border border-[#12807b] shadow-inner">
    </div>

    <div id="options" class="space-y-3 overflow-y-auto max-h-48 pr-2 bg-green-50 rounded-xl border border-green-300 p-3 shadow">
    </div>
</div>
@endsection

