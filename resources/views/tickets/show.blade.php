@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold text-[#37587a] mb-6">🗂️ Detalle del Ticket #{{ $ticket->id }}</h2>

    <p class="mb-2"><strong class="text-gray-700">Asunto:</strong> {{ $ticket->title }}</p>
    <p class="mb-2"><strong class="text-gray-700">Descripción:</strong> {{ $ticket->description }}</p>
    <p class="mb-2"><strong class="text-gray-700">Departamento:</strong> {{ $ticket->department }}</p>
    <p class="mb-2"><strong class="text-gray-700">Prioridad:</strong> {{ ucfirst($ticket->priority) }}</p>
    <p class="mb-2">
        <strong class="text-gray-700">Estado:</strong>
        @if($ticket->status === 'pending')
            <span class="text-yellow-600 font-medium">Pendiente</span>
        @elseif($ticket->status === 'en_proceso')
            <span class="text-blue-600 font-medium">En proceso</span>
        @else
            <span class="text-green-600 font-medium">Resuelto</span>
        @endif
    </p>

    @if($ticket->response)
        <hr class="my-4">
        <p class="mb-2"><strong class="text-gray-700">Respuesta del técnico:</strong> {{ $ticket->response }}</p>
        <p class="mb-2"><strong class="text-gray-700">Tiempo estimado:</strong> {{ $ticket->estimated_time }}</p>
    @endif

    @if($ticket->technician)
        <p class="mb-2"><strong class="text-gray-700">Técnico asignado:</strong> {{ $ticket->technician->name }} {{ $ticket->technician->last_name }}</p>
    @endif

    @if($ticket->attachment)
        <p class="mb-2">
            <strong class="text-gray-700">Archivo adjunto:</strong>
            <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="text-blue-500 underline">Ver archivo</a>
        </p>
    @endif

    <div class="mt-6">
        <a href="{{ route('tickets.index') }}" class="text-white bg-[#12807b] hover:bg-[#0f6a69] px-4 py-2 rounded shadow">← Volver a mis tickets</a>
    </div>
</div>
@endsection
