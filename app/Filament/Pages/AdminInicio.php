<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\TicketStats;
use App\Filament\Widgets\TicketTable;
use App\Filament\Widgets\FrequentIssuesChart;
use App\Filament\Widgets\TicketsByPriorityChart;
use App\Filament\Widgets\TicketSummaryTable;
use Filament\Pages\Page;
use App\Filament\Widgets\PendingTicketsNotification;


class AdminInicio extends Page
{
    protected static int $columns = 12;
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'Panel Administrador';
    protected static ?string $navigationLabel = 'Inicio';
    protected static ?string $slug = '/'; // Esto hace que sea la página /admin directamente
    protected static string $view = 'filament.pages.admin-inicio';

    protected function getHeaderWidgets(): array
    {
        return [
 
        TicketStats::class,
       // Segunda fila: TicketTable (6) + FrequentIssuesChart (6)
        TicketTable::class,
        FrequentIssuesChart::class,
        

        // Tercera fila: Últimos Resueltos (6) + Por Prioridad (6)
        TicketSummaryTable::class,
        TicketsByPriorityChart::class,
        
        
        
        
      
       
        
    ];
        
    }
 


}

    






