<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TicketsPerMonthChart extends ChartWidget
{
    protected static ?string $heading = 'Tickets por mes';

    protected int | string | array $columnSpan = 'two-thirds';

    protected function getData(): array
    {
        $data = DB::table('tickets')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, COUNT(*) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->pluck('total', 'mes');

        // Traduce y formatea el mes y año (ej: Mayo 2025)
        $labels = $data->keys()->map(function ($mes) {
            return Carbon::parse($mes)->locale('es')->translatedFormat('F Y');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Tickets',
                    'data' => $data->values(),
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => '#93C5FD',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
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
