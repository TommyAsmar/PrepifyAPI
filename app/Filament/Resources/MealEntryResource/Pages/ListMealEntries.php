<?php

namespace App\Filament\Resources\MealEntryResource\Pages;

use App\Filament\Resources\MealEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMealEntries extends ListRecords
{
    protected static string $resource = MealEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
