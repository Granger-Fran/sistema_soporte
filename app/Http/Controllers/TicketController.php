<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        // Validar datos del formulario
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'department' => 'required|string|max:255',
            'priority' => 'required|string|in:alta,media,baja',
            'attachment' => 'nullable|file|max:2048',
        ]);

        // Subida del archivo si se adjunta
        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        // Agregar campos adicionales
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        // Guardar en la base de datos
        Ticket::create($validated);

        // Redirigir con mensaje
        return redirect()->route('user.home')->with('success', 'Ticket enviado correctamente.');
    }

    public function index()
    {
        // Obtiene todos los tickets del usuario autenticado, ordenados por fecha de creación descendente
        $tickets = Ticket::with('technician') // Carga relación técnico
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();

    // Retorna la vista con los tickets
        return view('tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
{
    // Asegurarse que solo el dueño pueda ver
    if ($ticket->user_id != Auth::id()) {
        abort(403);
    }

    // Solo marcar como leído si tiene respuesta y no estaba leído
    if ($ticket->response && !$ticket->user_read) {
        $ticket->user_read = true;
        $ticket->save();
    }

    return view('tickets.show', compact('ticket'));
}


}
