<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TicketSummaryTable extends BaseWidget
{
   protected int | string | array $columnSpan = 6;
    protected static ?string $heading = 'Últimos Tickets Resueltos';

    protected function getTableQuery(): Builder
    {
        return Ticket::where('status', 'resuelto')
                     ->latest()
                     ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('title')
                ->label('Asunto'),

            TextColumn::make('priority')
                ->label('Prioridad')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'alta' => 'danger',
                    'media' => 'warning',
                    'baja' => 'success',
                    default => 'gray',
                }),

            TextColumn::make('updated_at')
                ->label('Resuelto el')
                ->dateTime('d M, Y H:i'),
        ];
    }
}
