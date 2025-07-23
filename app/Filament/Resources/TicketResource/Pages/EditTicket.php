<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormSchema(): array
{
    return [
        Textarea::make('response')
            ->label('Respuesta del técnico')
            ->required()
            ->placeholder('Describe la solución al problema...'),

        TextInput::make('estimated_time')
            ->label('Tiempo estimado')
            ->type('time')
            ->required(),

        Placeholder::make('nota')
            ->label('Importante')
            ->content('Solo puedes modificar la respuesta y el tiempo asignado.'),
    ];
}
}
