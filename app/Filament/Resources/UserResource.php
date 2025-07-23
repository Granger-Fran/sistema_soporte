<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Usuarios'; // Nombre del ítem en el menú lateral
    }

    public static function getPluralLabel(): ?string
    {
        return 'Administración Usuarios'; //Título principal
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            
                Forms\Components\TextInput::make('name')
                ->label('Nombre')
                ->required(),
    
            Forms\Components\TextInput::make('last_name')
                ->label('Apellido')
                ->required(),
    
            Forms\Components\TextInput::make('email')
                ->label('Correo electrónico')
                ->email()
                ->required(),
    
            Forms\Components\TextInput::make('department')
                ->label('Departamento'),
    
            Forms\Components\TextInput::make('phone')
                ->label('Teléfono'),
    
            Forms\Components\Select::make('role')
                ->label('Rol')
                ->options([
                    'admin' => 'Administrador',
                    'user' => 'Usuario',
                ])
                ->required(),
    
            Forms\Components\Toggle::make('active')
                ->label('Activo'),
    
            Forms\Components\TextInput::make('password')
                ->label('Contraseña')
                ->password()
                ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nombre'),
                Tables\Columns\TextColumn::make('last_name')->label('Apellido'),
                Tables\Columns\TextColumn::make('email')->label('Correo electrónico'),
                Tables\Columns\TextColumn::make('department')->label('Departamento'),
                Tables\Columns\TextColumn::make('role')->label('Rol'),
                Tables\Columns\IconColumn::make('active')->label('Activo')->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
                Tables\Actions\DeleteAction::make()->label('Eliminar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
