<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\TicketsPerMonthChart;
use App\Filament\Widgets\TicketsByDepartmentChart;
use App\Filament\Widgets\TopTechniciansChart;

class Estadisticas extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.estadisticas';

    public function getHeaderWidgets(): array
    {
        return [
            
            TicketsPerMonthChart::class,
            TopTechniciansChart::class, 
            TicketsByDepartmentChart::class,
        ];
    }




}
