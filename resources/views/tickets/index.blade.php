
@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-[#37587a] mb-6">📄 Mis Tickets</h2>

    @if($tickets->isEmpty())
        <p class="text-gray-600">No tienes tickets registrados.</p>
    @else
        <div class="space-y-4">
            @foreach($tickets as $ticket)
                <div class="border border-gray-200 rounded-lg p-4 shadow-sm bg-white">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-[#2d4e6b]">
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="hover:underline">
                                #{{ $ticket->id }} - {{ $ticket->title }}
                            </a>
                            @if(!$ticket->user_read && $ticket->response)
                                <span class="ml-2 text-red-500 text-sm">🔔 Nuevo</span>
                            @endif
                        </h3>
                        <span class="text-sm text-gray-500">{{ $ticket->created_at->format('d M Y H:i') }}</span>
                    </div>

                    <p class="text-gray-700">
                        <strong>Descripción:</strong> {{ $ticket->description }}
                    </p>

                    <p class="text-gray-700 mt-1">
                        <strong>Departamento:</strong> {{ $ticket->department }}
                    </p>

                    <p class="text-gray-700">
                        <strong>Prioridad:</strong> {{ ucfirst($ticket->priority) }}
                    </p>

                    <p class="text-gray-700">
                        <strong>Estado:</strong>
                        @if($ticket->status === 'pending')
                            <span class="text-yellow-600 font-medium">Pendiente</span>
                        @elseif($ticket->status === 'en_proceso')
                            <span class="text-blue-600 font-medium">En proceso</span>
                        @else
                            <span class="text-green-600 font-medium">Resuelto</span>
                        @endif
                    </p>

                    {{-- ✅ Nota: NO mostramos respuesta, tiempo, técnico ni archivo aquí.
                         Esos se ven en la vista "show" --}}
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
