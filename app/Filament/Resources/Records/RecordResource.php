<?php

namespace App\Filament\Resources\Records;

use App\Filament\Resources\Records\Pages;
use App\Models\Record;
use BackedEnum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

// --- EXPLICIT IMPORTS FOR V4 ---
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class RecordResource extends Resource
{
    protected static ?string $model = Record::class;

    // Use a string for the icon to be safe
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $recordTitleAttribute = 'year';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. The Magic Dropdown (Select Species by Name)
                Forms\Components\Select::make('species_id')
                    ->relationship('species', 'common_name') // Looks up 'common_name' in Species table
                    ->searchable() // Allows typing to find the name
                    ->preload() // Loads the list instantly
                    ->required()
                    ->label('Butterfly Species'),

                    Forms\Components\DatePicker::make('sighting_date')
    ->label('Date Sighted')
    ->required(),

                // 2. Year
                Forms\Components\TextInput::make('year')
                    ->required()
                    ->numeric()
                    ->default(2024),

                // 3. Count
                Forms\Components\TextInput::make('count')
                    ->required()
                    ->numeric()
                    ->label('Number Sighted'),

                // 4. Coordinates
                Forms\Components\TextInput::make('latitude')
                    ->required()
                    ->numeric(),

                Forms\Components\TextInput::make('longitude')
                    ->required()
                    ->numeric(),

                // 5. Grid Ref (Optional text)
                Forms\Components\TextInput::make('grid_ref')
                    ->label('Grid Reference (e.g. SP50)')
                    ->placeholder('Optional'),
                // 6. Observer Name (Optional)
                Forms\Components\TextInput::make('observer')
    ->label('Observer Name')
    ->placeholder('e.g. Mark Calway'),

Forms\Components\Textarea::make('notes')
    ->label('Sighting Notes')
    ->rows(3)
    ->columnSpanFull(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Show the Species Name instead of the ID number
                Tables\Columns\TextColumn::make('species.common_name')
                    ->label('Species')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('year')
                    ->sortable(),

                Tables\Columns\TextColumn::make('count')
                    ->label('Count'),
                    
                Tables\Columns\TextColumn::make('grid_ref')
                    ->label('Grid Ref'),
            ])
            ->actions([
                // V4 Action
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
            'index' => Pages\ListRecords::route('/'),
            'create' => Pages\CreateRecord::route('/create'),
            'edit' => Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}