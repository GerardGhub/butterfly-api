<?php

namespace App\Filament\Resources\Records\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RecordForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('species_id')
                    ->required()
                    ->numeric(),
                TextInput::make('year')
                    ->required()
                    ->numeric(),
                TextInput::make('count')
                    ->required()
                    ->numeric(),
                TextInput::make('latitude')
                    ->required()
                    ->numeric(),
                TextInput::make('longitude')
                    ->required()
                    ->numeric(),
                TextInput::make('grid_ref'),
            ]);
    }
}
