<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;




class TicketTable extends BaseWidget
{
    protected int | string | array $columnSpan = 6;
    

    protected function getTableQuery(): Builder
    {
         return Ticket::where('status', 'pending')->latest();
    }
    
    
    protected function getTableColumns(): array
    {
        return [
            
            
            TextColumn::make('priority')
                ->label('Prioridad')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'alta' => 'danger',
                    'media' => 'warning',
                    'baja' => 'success',
                    default => 'gray',
                }),

            TextColumn::make('title')
                ->label('Asunto')
                ->searchable()
                ->sortable(),

            TextColumn::make('description')
                ->label('Descripción')
                ->searchable()
                ->sortable(),
                            
            TextColumn::make('attachment')
                ->label('Archivo adjunto')
                ->formatStateUsing(function (?string $state) {
                    return $state ? '📎 Ver archivo' : 'Sin archivo';
                })
                ->url(fn ($record) => $record->attachment ? Storage::url($record->attachment) : null)
                ->openUrlInNewTab()
                ->color('info'),
           
            /*TextColumn::make('user.name')
                ->label('Solicitante')
                ->formatStateUsing(fn ($state, $record) => $record->user?->name . ' ' . $record->user?->last_name),
                
            TextColumn::make('department')
                ->label('Departamento')
                ->searchable()
                ->sortable(),
                
            TextColumn::make('status')
                ->label('Estado')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                    'en_proceso' => 'info',
                    'resuelto' => 'success',
                    default => 'gray',
                })
                ->formatStateUsing(function (string $state): string {
                    return match ($state) {
                        'pending' => 'Pendiente',
                        'en_proceso' => 'En proceso',
                        'resuelto' => 'Resuelto',
                        default => ucfirst($state),
                    };
                }),*/

            TextColumn::make('created_at')
                ->label('Fecha')
                ->dateTime('d M, Y H:i'),
        ];
    }

    /*-------------------------------------------------------------------*/
    /* Parte accion al apretar el boton de VER*/
    /*-------------------------------------------------------------------*/
protected function getTableActions(): array
{
    return [
        Action::make('Ver')
            ->icon('heroicon-o-eye')
            ->modalHeading('Detalles del Ticket')
            ->modalSubmitActionLabel('Guardar respuesta')
            ->modalWidth('2xl')
            ->form(fn (Ticket $record) => [
                TextInput::make('title')
                    ->label('Asunto')
                    ->default($record->title)
                    ->disabled(),

                Textarea::make('description')
                    ->label('Descripción')
                    ->default($record->description)
                    ->disabled(),

                TextInput::make('department')
                    ->label('Departamento')
                    ->default($record->department)
                    ->disabled(),

                 // Solicitante
                TextInput::make('user')
                    ->label('Solicitante')
                    ->default($record->user?->name . ' ' . $record->user?->last_name)
                    ->disabled(),

                TextInput::make('priority')
                    ->label('Prioridad')
                    ->default($record->priority)
                    ->disabled(),

                TextInput::make('status')
                    ->label('Estado')
                    ->default(__($record->status === 'pending' ? 'Pendiente' : ($record->status === 'en_proceso' ? 'En proceso' : 'Resuelto')))
                    ->disabled(),

                FileUpload::make('attachment')
                    ->label('Archivo adjunto')
                    ->default($record->attachment)
                    ->directory('attachments')
                    ->downloadable()
                    ->openable()
                    ->disabled(),

               // Técnico responsable
                TextInput::make('technician')
                    ->label('Técnico responsable')
                    ->default($record->technician?->name . ' ' . $record->technician?->last_name ?? 'No asignado')
                    ->disabled(),

                // Respuesta editable solo si el estado es válido
                Textarea::make('response')
                    ->label('Respuesta')
                     ->default(fn ($record) => $record->response)
                    ->placeholder('Escribe aquí la solución...')
                    ->visible(fn () => in_array($record->status, ['pending', 'en_proceso'])),

                

                TextInput::make('estimated_time')
                    ->label('Tiempo estimado')
                    ->type('time') // Esto genera un selector como "08:30"
                    ->placeholder('HH:MM')
            ])
            ->action(function (Ticket $record, array $data) {
                $record->update([
                    'response' => $data['response'],
                    'estimated_time' => $data['estimated_time'],
                    'status' => 'en_proceso',
                   'technician_id' => Auth::id(),


                ]);

                Notification::make()
                    ->title('Respuesta guardada correctamente')
                    ->success()
                    ->send();
            }),
    ];
}

protected function getTableWrapperClasses(): ?string
{
    return 'overflow-y-auto max-h-[100px]';
}

}




