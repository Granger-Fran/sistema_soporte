<?php

namespace App\Filament\Widgets;


use App\Models\Ticket;
use Filament\Widgets\ChartWidget;

class FrequentIssuesChart extends ChartWidget
{
    protected static ?string $heading = 'Problemas más frecuentes';
    protected int | string | array $columnSpan = 6;
    


    protected function getData(): array
    {
        $issues = Ticket::select('title')
        ->selectRaw('count(*) as total')
        ->groupBy('title')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad',
                    'data' => $issues->pluck('total'),
                    'backgroundColor' => [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
                    ],
                ],
            ],
            'labels' => $issues->pluck('title'),        
     ];
    }

    protected function getType(): string
    {
        return 'bar'; // Tipo de gráfico
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
