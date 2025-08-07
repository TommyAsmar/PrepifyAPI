<?php

namespace App\Filament\Resources\MealEntryResource\Pages;

use App\Filament\Resources\MealEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMealEntry extends EditRecord
{
    protected static string $resource = MealEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
