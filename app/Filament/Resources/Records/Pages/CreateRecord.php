<?php

namespace App\Filament\Resources\Records\Pages;

use App\Filament\Resources\Records\RecordResource;
use Filament\Resources\Pages\CreateRecord as BaseCreateRecord;

class CreateRecord extends BaseCreateRecord
{
    protected static string $resource = RecordResource::class;
}
