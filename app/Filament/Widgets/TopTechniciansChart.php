<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TopTechniciansChart extends ChartWidget
{
    protected static ?string $heading = 'Técnicos con más tickets resueltos';

    protected int | string | array $columnSpan = 'two-thirds';

    protected function getData(): array
    {
        $data = DB::table('tickets')
            ->select('technician_id', DB::raw('COUNT(*) as total'))
            ->whereNotNull('technician_id')
            ->groupBy('technician_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Convertir IDs a nombres si tienes la relación con la tabla de usuarios
        $labels = $data->pluck('technician_id')->map(function ($id) {
            $user = DB::table('users')->find($id);
            return $user ? "{$user->name} {$user->last_name}" : "Técnico ID {$id}";
        });

        return [
            'datasets' => [
                [
                    'label' => 'Tickets resueltos',
                    'data' => $data->pluck('total'),
                    'backgroundColor' => ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
