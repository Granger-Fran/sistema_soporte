<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;
use App\Models\Ticket;

class UserHomeController extends Controller
{
    public function home()
    {
         $userId = auth()->id();

    // Notificaciones = tickets respondidos pero no leídos
    $notificationsCount = Ticket::where('user_id', $userId)
        ->whereNotNull('response')
        ->where('user_read', false)
        ->count();


       // Solo avisos activos
        $notices = Notice::where('is_active', 1)->latest()->get();

        // Enviarlos a la vista
        return view('user.home', compact('notices'));
    }





}
