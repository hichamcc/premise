<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionnaireResource\Pages;
use App\Filament\Resources\QuestionnaireResource\RelationManagers;
use App\Models\Questionnaire;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionnaireResource extends Resource
{

    protected static ?string $model = Questionnaire::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('genre')
                    ->label(' Genre')
                    ->placeholder('Male or Female')
                    ->required(),
                TextInput::make('physical_activity')
                    ->label('Level of Physical Activity')
,                TextInput::make('goal')
                    ->label('Goal')
,                TextInput::make('target_zones')
                    ->label('Target Zones')
,                TextInput::make('walks_frequency')
                    ->label('Walks Frequency')
,                TextInput::make('habits')
                    ->label('Habits')
,                TextInput::make('meals_per_day')
                    ->label('Meals Per Day')
,                TextInput::make('sleep_hours_per_night')
                    ->label('Sleep Hours Per Night')
,                TextInput::make('water_consumption')
                    ->label('Water Consumption')
,                TextInput::make('age')
                    ->label(' Age')
                    ->required(),
                TextInput::make('current_weight')
                    ->label(' Current Weight')
                    ->required(),
                TextInput::make('height')
                    ->label(' Height')
                    ->required(),
                TextInput::make('desired_weight')
                    ->label(' Desired Weight')
                    ->required(),
                Select::make('calculation_choice')
                    ->label('Calculations and Writing')
                    ->options([
                        'keep_choice' => 'I Keep This Choice',
                        'speed_up_process' => 'I Need to Speed Up the Process',
                    ])
                    ->required(),
                TextInput::make('vegetables_not_eaten')
                    ->label(' Vegetables You Don\'t Eat')
,                TextInput::make('fruits_not_eaten')
                    ->label(' Fruits You Don\'t Eat')
,                TextInput::make('oilseeds_not_eaten')
                    ->label(' Oilseeds You Don\'t Eat')
,                TextInput::make('legumes_not_eaten')
                    ->label(' Legumes You Don\'t Eat')
,                TextInput::make('dairy_products_not_eaten')
                    ->label(' Dairy Products You Don\'t Eat')
,                TextInput::make('meat_not_eaten')
                    ->label(' Meat You Don\'t Eat')
,                TextInput::make('fish_not_eaten')
                    ->label(' Fish You Don\'t Eat')
,                TextInput::make('intolerances_or_allergies')
                    ->label('Do You Have One or More of These Intolerances and/or Allergies?')
,                TextInput::make('diseases_diagnosed_by_doctor')
                    ->label('Do You Have Any of These Diseases? (Diagnosed by a Doctor)')
,                TextInput::make('left_arm_circumference')
                    ->label('Left Arm Circumference')
,                TextInput::make('waist_circumference')
                    ->label('Waist Circumference'),
                TextInput::make('hip_circumference')
                    ->label('Hip Circumference'),
                TextInput::make('chest_circumference')
                    ->label('Chest Circumference'),
                FileUpload::make('front_photo')
                    ->image()
                    ->directory('photos')
                    ->label('Front Photo'),
                FileUpload::make('side_photos')
                    ->image()
                    ->label('Side Photos'),
                FileUpload::make('back_photo')
                    ->image()
                    ->label('Back Photo'),
                ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('goal')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('age')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('current_weight')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('desired_weight')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('calories')
                    ->label('Calculated calories')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListQuestionnaires::route('/'),
            'create' => Pages\CreateQuestionnaire::route('/create'),
            'edit' => Pages\EditQuestionnaire::route('/{record}/edit'),
        ];
    }
}
