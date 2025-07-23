<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat as Card;

class TicketStats extends BaseWidget
{
    protected int | string | array $columnSpan = 12;

    protected function getCards(): array
    {
        return [

            Card::make('Total de solicitudes', Ticket::count())
                ->description('Todos los tickets registrados')
                ->color('gray'),
          
            //ticket pendientes aqui dbemos modificar para que al hacer clic nos lleve a este filtro
            
            Card::make('Pendientes', Ticket::where('status', 'pending')->count())
                ->description('Tickets sin atender')
                ->color('danger')
                ->icon('heroicon-o-bell-alert')
                //->extraAttributes(['class' => 'text-green-600'])
                ->url(route('filament.admin.resources.tickets.index', [
                'tableFilters' => [
                'status' => [
                'value' => 'pending',
                ],
            ],
        ])),
     

            Card::make('En proceso', Ticket::where('status', 'en_proceso')->count())
                ->description('Tickets  en revisión')
                ->color('info')
                 ->icon('heroicon-o-adjustments-vertical')
                 ->url(route('filament.admin.resources.tickets.index', [
                'tableFilters' => [
                'status' => [
                'value' => 'En_proceso',
                ],
            ],
        ])),
                

            Card::make('Resueltos', Ticket::where('status', 'resuelto')->count())
                ->description('Tickets finalizados')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->url(route('filament.admin.resources.tickets.index', [
                'tableFilters' => [
                'status' => [
                'value' => 'resueltos',
                ],
            ],
        ])),
        ];
    }
}

 
