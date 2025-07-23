<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Ticket;
use Filament\Support\Icons\Icon;

class PendingTicketsNotification extends Widget
{
    protected static string $view = 'filament.widgets.pending-tickets-notification';

    protected static ?int $sort = -1; // Aparece al inicio

    protected static bool $isLazy = false;

    protected static bool $isVisible = true;

    protected function getViewData(): array
    {
        return [
            'pendingCount' => Ticket::where('status', 'pending')->count(),
        ];
    }
}
