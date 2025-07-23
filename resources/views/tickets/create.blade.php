@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow text-gray-800">

    {{-- Ícono de ticket --}}
    <div class="flex justify-center mb-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m1 0h3a1 1 0 001-1v-3a2 2 0 110-4v-3a1 1 0 00-1-1h-3a2 2 0 11-4 0H9a2 2 0 11-4 0H2a1 1 0 00-1 1v3a2 2 0 110 4v3a1 1 0 001 1h3a2 2 0 114 0z" />
        </svg>
    </div>

    <h2 class="text-xl font-bold mb-6 text-center text-gray-800">Formulario de Ingreso de Ticket</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Selector de asunto o campo personalizado --}}
        <div class="mb-4">
            <label for="title_select" class="block text-sm font-semibold text-gray-700">Asunto del problema</label>
            <select id="title_select" name="title" onchange="toggleCustomTitle(this)"
                class="w-full p-2 border rounded text-gray-800" required>
                <option value="">Seleccione una opción</option>
                <option value="Pantalla">Pantalla</option>
                <option value="Internet">Internet</option>
                <option value="Impresora">Impresora</option>
                <option value="Correo">Correo</option>
                <option value="Excel">Excel</option>
                <option value="Otro">Otro...</option>
            </select>
        </div>

        <div class="mb-4 hidden" id="custom-title-box">
            <label for="custom_title" class="block text-sm font-semibold text-gray-700">Especifique el asunto</label>
            <input type="text" id="custom_title" class="w-full p-2 border rounded text-gray-800"
                placeholder="Describa el problema específico">
        </div>

        <input type="hidden" name="title" id="hidden_title">

        <script>
            function toggleCustomTitle(select) {
                const customBox = document.getElementById('custom-title-box');
                const customInput = document.getElementById('custom_title');
                const hiddenTitle = document.getElementById('hidden_title');

                if (select.value === 'Otro') {
                    customBox.classList.remove('hidden');
                    customInput.required = true;
                    hiddenTitle.value = '';
                    customInput.addEventListener('input', () => {
                        hiddenTitle.value = customInput.value;
                    });
                } else {
                    customBox.classList.add('hidden');
                    customInput.required = false;
                    hiddenTitle.value = select.value;
                }
            }
        </script>

        <div class="mb-4">
            <label for="description" class="block text-sm font-semibold text-gray-700">Descripción detallada</label>
            <textarea name="description" class="w-full p-2 border rounded" rows="4" required></textarea>
        </div>

        <div class="mb-4">
            <label for="department" class="block font-semibold mb-1">Departamento</label>
            <input type="text" name="department" value="{{ Auth::user()->department }}" readonly class="w-full p-2 border bg-gray-100 rounded">
        </div>

        <div class="mb-4">
            <label for="priority" class="block text-sm font-semibold text-gray-700">Prioridad</label>
            <select name="priority" class="w-full p-2 border rounded text-gray-800" required>
                <option value="">Seleccione una opción</option>
                <option value="alta">Alta</option>
                <option value="media">Media</option>
                <option value="baja">Baja</option>
            </select>
        </div>

        <div class="mb-6">
            <label for="attachment" class="block text-sm font-semibold text-gray-700">Archivo adjunto (opcional)</label>
            <input type="file" name="attachment" class="w-full p-2 border rounded">
        </div>

        {{-- Botones centrados --}}
        <div class="flex justify-center gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
                Enviar Ticket
            </button>

            <a href="{{ route('user.home') }}"
               class="bg-gray-500 hover:bg-gray-700 text-white px-6 py-2 rounded shadow">
               Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
