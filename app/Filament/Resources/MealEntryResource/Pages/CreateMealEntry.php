<?php

namespace App\Filament\Resources\MealEntryResource\Pages;

use App\Filament\Resources\MealEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMealEntry extends CreateRecord
{
    protected static string $resource = MealEntryResource::class;
}
