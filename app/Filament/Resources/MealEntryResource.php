<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MealEntryResource\Pages;
use App\Filament\Resources\MealEntryResource\RelationManagers;
use App\Models\MealEntry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MealEntryResource extends Resource
{
    protected static ?string $model = MealEntry::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('meal_plan_id')->relationship('mealPlan', 'title')->required(),
                Forms\Components\Select::make('recipe_id')->relationship('recipe', 'title')->required(),
                Forms\Components\Select::make('day_of_week')->options([
                    'Monday' => 'Monday',
                    'Tuesday' => 'Tuesday',
                    'Wednesday' => 'Wednesday',
                    'Thursday' => 'Thursday',
                    'Friday' => 'Friday',
                    'Saturday' => 'Saturday',
                    'Sunday' => 'Sunday',
                ])->required(),
                Forms\Components\Select::make('meal_type')->options([
                    'Breakfast' => 'Breakfast',
                    'Lunch' => 'Lunch',
                    'Dinner' => 'Dinner',
                    'Snack' => 'Snack',
                ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mealPlan.title')
                    ->label('Meal Plan')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('recipe.title')
                    ->label('Recipe')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('day_of_week')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('meal_type')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMealEntries::route('/'),
            'create' => Pages\CreateMealEntry::route('/create'),
            'edit' => Pages\EditMealEntry::route('/{record}/edit'),
        ];
    }
}
