<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DietPlanResource\Pages;
use App\Filament\Resources\DietPlanResource\RelationManagers;
use App\Models\DietPlan;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DietPlanResource extends Resource
{
    protected static ?string $model = DietPlan::class;
    protected static ?string $navigationLabel = 'Daily users plans';

    public static function canCreate(): bool
    {
        return false;
    }

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                RichEditor::make('description')
                    ->required()
                    ->label('Diet')
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->maxLength(65535),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(DietPlan::upcoming())

            ->columns([
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('diet.name')
                    ->sortable()
                    ->label('Diet')
                    ->searchable(),

                TextColumn::make('day')
                    ->sortable()
                    ->searchable()
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

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
            'index' => Pages\ListDietPlans::route('/'),
            'create' => Pages\CreateDietPlan::route('/create'),
            'edit' => Pages\EditDietPlan::route('/{record}/edit'),
        ];
    }
}
