<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Actions\Action;
use Filament\Infolists\Components\TextEntry;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema(static::getFormSchema());
    }

    public static function table(Table $table): Table
    {
        // ✅ NUEVA acción Ver Detalle
        $verAction = Action::make('ver')
            ->label('Ver Detalle')
            ->icon('heroicon-o-eye')
            ->modalHeading('📝 Detalle del Ticket')
            ->modalSubmitActionLabel('Cerrar')
            ->modalWidth('lg')
            ->infolist([
                TextEntry::make('title')
                ->label('Asunto')
                 ->inlineLabel()
                 ->color('primary'),

                TextEntry::make('description')->label('Descripción')
                ->inlineLabel()
                 ->color('primary'),

                TextEntry::make('priority')->label('Prioridad')
                ->inlineLabel()
                 ->color('primary'),

                TextEntry::make('status')->label('Estado')
                ->inlineLabel()
                 ->color('primary'),

                TextEntry::make('response')
                    ->label('Respuesta')
                    ->default('Aún sin responder')
                    ->inlineLabel()
                 ->color('primary'),

                TextEntry::make('attachment')
                    ->label('Archivo adjunto')
                    ->url(fn ($record) => $record->attachment ? Storage::url($record->attachment) : null)
                    ->openUrlInNewTab()
                    ->formatStateUsing(fn ($state) => $state ? '📎 Ver archivo' : 'Sin archivo')
                    ->inlineLabel()
                 ->color('primary'),

                    

            ]);

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable()->searchable(),

                Tables\Columns\TextColumn::make('priority')
                    ->label('Prioridad')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'alta' => 'danger',
                        'media' => 'warning',
                        'baja' => 'success',
                        default => 'gray',
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'pending' => 'warning',
                        'en_proceso' => 'info',
                        'resuelto' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'pending' => 'Pendiente',
                        'en_proceso' => 'En proceso',
                        'resuelto' => 'Resuelto',
                        default => ucfirst($state),
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')->label('Asunto')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('description')->label('Descripción')->sortable()->searchable(),

                Tables\Columns\TextColumn::make('attachment')
                    ->label('Archivo adjunto')
                    ->formatStateUsing(fn (?string $state) => $state ? '📎 Ver archivo' : 'Sin archivo')
                    ->url(fn ($record) => $record->attachment ? Storage::url($record->attachment) : null)
                    ->openUrlInNewTab()
                    ->color('info'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Solicitante')
                    ->formatStateUsing(fn ($state, $record) => $record->user?->name . ' ' . $record->user?->last_name)
                    ->searchable(),

                Tables\Columns\TextColumn::make('department')->label('Departamento')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('response')->label('Respuesta')->formatStateUsing(fn (?string $state) => $state ?: '-')->limit(50),
                Tables\Columns\TextColumn::make('estimated_time')->label('Tiempo estimado')->formatStateUsing(fn (?string $state) => $state ?: '-'),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha')->dateTime('d-m-Y H:i')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('technician.name')
                    ->label('Técnico asignado')
                    ->formatStateUsing(fn ($state, $record) => $record->technician?->name . ' ' . $record->technician?->last_name)
                    ->sortable()
                    ->searchable(),
            ])

            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'pending' => 'Pendiente',
                        'in_process' => 'En proceso',
                        'resolved' => 'Resuelto',
                    ]),
            ])

            // ✅ DECLARA TODAS LAS ACCIONES PRIMERO
            ->actions([
                $verAction,

                Tables\Actions\Action::make('Responder')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->modalHeading(fn (Ticket $record) => 'Responder al ticket # ' . $record->id)
                    ->modalSubmitActionLabel('Guardar respuesta')
                    ->modalWidth('xl')
                    ->visible(fn (Ticket $record) => in_array($record->status, ['pending', 'en_proceso']))
                    ->form([
                        Forms\Components\TextInput::make('ticket_id')
                            ->label('ID del Ticket')
                            ->default(fn (Ticket $record) => $record->id)
                            ->disabled(),

                        Forms\Components\TextInput::make('title')
                            ->label('Asunto')
                            ->default(fn (Ticket $record) => $record->title)
                            ->disabled(),

                        Forms\Components\Textarea::make('description')
                            ->label('Descripción')
                            ->default(fn (Ticket $record) => $record->description)
                            ->disabled(),

                        Forms\Components\TextInput::make('department')
                            ->label('Departamento')
                            ->default(fn (Ticket $record) => $record->department)
                            ->disabled(),

                        Forms\Components\TextInput::make('user')
                            ->label('Solicitante')
                            ->default(fn (Ticket $record) => $record->user?->name . ' ' . $record->user?->last_name)
                            ->disabled(),

                        Forms\Components\TextInput::make('priority')
                            ->label('Prioridad')
                            ->default(fn (Ticket $record) => $record->priority)
                            ->disabled(),

                        Placeholder::make('archivo_adjunto')
                            ->label('Archivo adjunto')
                            ->content(fn ($record) => $record->attachment ? '📎 Archivo disponible' : 'Sin archivo')
                            ->visible(fn ($record) => filled($record->attachment)),

                        Forms\Components\Textarea::make('response')
                            ->label('Respuesta')
                            ->placeholder('Escriba aquí la solución...')
                            ->required(),

                        Forms\Components\TextInput::make('estimated_time')
                            ->label('Tiempo estimado')
                            ->type('time')
                            ->placeholder('HH:MM'),
                    ])
                    ->action(function (Ticket $record, array $data) {
                        $record->update([
                            'response' => $data['response'],
                            'estimated_time' => $data['estimated_time'],
                            'status' => 'en_proceso',
                            'technician_id' => auth()->id(),
                        ]);
                    }),

                Tables\Actions\Action::make('Resuelto')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'en_proceso')
                    ->requiresConfirmation()
                    ->action(fn (Ticket $record) => $record->update(['status' => 'resuelto'])),

                Tables\Actions\DeleteAction::make(),
            ])

            // ✅ Y LUEGO RECORDACTION
            ->recordAction('ver')

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            // 'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
