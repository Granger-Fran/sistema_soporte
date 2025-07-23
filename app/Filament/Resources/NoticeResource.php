<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NoticeResource\Pages;
use App\Filament\Resources\NoticeResource\RelationManagers;
use App\Models\Notice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn; // si es imagen
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\DateColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Toggle;




class NoticeResource extends Resource
{
    protected static ?string $model = Notice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 TextInput::make('title')
                ->label('Título'),
                

                Textarea::make('content')
                ->label('Descripción'),
                

                FileUpload::make('image')
                ->label('Folleto (Imagen)')
                ->image()
                ->directory('notices')
                ->disk('public')
                ->preserveFilenames(false) // <- ¡Muy importante!
                ->imagePreviewHeight('250')
                ->maxSize(5120),

                 TextInput::make('created_at')
                ->label('Fecha de creación')
                ->default(now()->format('d-m-Y H:i'))
                ->disabled(),

                Toggle::make('is_active')
                ->label('Aviso activo')
            ->default(true),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                 TextColumn::make('title')
                ->label('Título')
                ->searchable()
                ->sortable(),

                TextColumn::make('content')
                ->label('Contenido')  
                ->limit(250),

               ImageColumn::make('image')
                ->label('Folleto')             
                ->getStateUsing(fn ($record) => asset('storage/' . $record->image))
                ->openUrlInNewTab()
                ->height(60),

                TextColumn::make('created_at')
                 ->label('Fecha Publicación')
                ->date()
                ->sortable(),

                IconColumn::make('is_active')
                ->label('Activo')
                ->boolean(),


            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                 Tables\Actions\ViewAction::make(),
                 Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListNotices::route('/'),
            'create' => Pages\CreateNotice::route('/create'),
            'edit' => Pages\EditNotice::route('/{record}/edit'),
        ];
    }
}
