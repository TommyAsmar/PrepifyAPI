<?php

namespace App\Filament\Resources\MealPlanResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Recipe;
use Filament\Resources\RelationManagers\RelationManager;

class MealEntriesRelationManager extends RelationManager
{
    protected static string $relationship = 'mealEntries'; // name of the relationship method on MealPlan model

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Select::make('recipe_id')
                ->relationship('recipe', 'title')
                ->required(),
            Forms\Components\TextInput::make('day_of_week')->required(),
            Forms\Components\TextInput::make('meal_type')->required(),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('recipe.title')->label('Recipe'),
                Tables\Columns\TextColumn::make('day_of_week'),
                Tables\Columns\TextColumn::make('meal_type'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}