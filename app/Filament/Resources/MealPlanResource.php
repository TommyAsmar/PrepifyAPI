<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MealPlanResource\Pages;
use App\Filament\Resources\MealPlanResource\RelationManagers;
use App\Models\MealPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MealPlanResource extends Resource
{
    protected static ?string $model = MealPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('description')
                    ->maxLength(500),

                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name') // assumes MealPlan belongsTo User
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('description')->limit(50)->toggleable(),
                Tables\Columns\TextColumn::make('user.name')->label('User')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
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
            RelationManagers\MealEntriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMealPlans::route('/'),
            'create' => Pages\CreateMealPlan::route('/create'),
            'edit' => Pages\EditMealPlan::route('/{record}/edit'),
        ];
    }
}
