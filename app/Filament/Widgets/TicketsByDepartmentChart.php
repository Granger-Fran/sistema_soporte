<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Filament\Support\Js;

class TicketsByDepartmentChart extends ChartWidget
{
    protected static ?string $heading = 'Tickets por departamento';

    protected int | string | array $columnSpan = 'two-thirds';

    protected function getData(): array
    {
        $data = DB::table('tickets')
            ->select('department', DB::raw('COUNT(*) as total'))
            ->groupBy('department')
            ->orderByDesc('total')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Tickets',
                    'data' => $data->pluck('total'),
                    'backgroundColor' => ['#34d399', '#60a5fa', '#facc15', '#f87171', '#a78bfa'],
                ],
            ],
            'labels' => $data->pluck('department'),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
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
