<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\ChartWidget;

class TicketsByPriorityChart extends ChartWidget
{
   protected int | string | array $columnSpan = 6;
    protected static ?string $heading = 'Tickets por Prioridad';

   
    

    protected function getData(): array
    {
        $priorities = ['alta', 'media', 'baja'];

        $counts = collect($priorities)->map(fn ($priority) =>
            Ticket::where('priority', $priority)->count()
        );

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad de Tickets',
                    'data' => $counts->toArray(),
                    'backgroundColor' => ['#dc2626', '#facc15', '#16a34a'], // rojo, amarillo, verde
                ],
            ],
            'labels' => ['Alta', 'Media', 'Baja'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

     protected function getOptions(): array
{
    return [
        'scales' => [
            'y' => [
                'ticks' => [
                    'stepSize' => 1,
                    'precision' => 0,
                    'beginAtZero' => true,
                ],
            ],
        ],
    ];
}
}
