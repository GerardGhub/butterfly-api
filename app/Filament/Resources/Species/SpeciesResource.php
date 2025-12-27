<?php

namespace App\Filament\Resources\Species;

use App\Filament\Resources\Species\Pages;
use App\Models\Species;
use BackedEnum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

// --- FILAMENT V4 ACTIONS (The Important Change) ---
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class SpeciesResource extends Resource
{
    protected static ?string $model = Species::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'common_name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('common_name')
                    ->label('Common Name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('scientific_name')
                    ->label('Scientific Name')
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('hero_image_path')
                    ->image()
                    ->directory('species_images'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('hero_image_path'),
                
                Tables\Columns\TextColumn::make('common_name')
                    ->sortable()
                    ->searchable(),

                // In v4, 'italic' is definitely an extra attribute
                Tables\Columns\TextColumn::make('scientific_name')
                    ->extraAttributes(['class' => 'italic']),
            ])
            ->actions([
                // We use the imported V4 action here
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListSpecies::route('/'),
            'create' => Pages\CreateSpecies::route('/create'),
            'edit' => Pages\EditSpecies::route('/{record}/edit'),
        ];
    }
}