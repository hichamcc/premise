<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DietResource\Pages;
use App\Filament\Resources\DietResource\RelationManagers;
use App\Models\Diet;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ReplicateAction;

class DietResource extends Resource
{
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    //protected static ?string $navigationGroup = 'Settings';


    protected static ?string $model = Diet::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required()
                ->maxLength(255),
                Select::make('type')
                    ->required()
                    ->options([
                        '2: Lunch and dinner'=>'2: Lunch and dinner',
                        '3: Breakfast, lunch and dinner'=> '3: Breakfast, lunch and dinner',
                        '4: Breakfast, lunch, snack, dinner'=>'4: Breakfast, lunch, snack, dinner',
                        '5: Breakfast, mid-morning snack, lunch, snack, dinner'=>'5: Breakfast, mid-morning snack, lunch, snack, dinner',
                    ])
                    ->label('Meals per day'),
                TextInput::make('calories')
                    ->required()
                    ->numeric()
                    ->minValue(0),
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
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('calories')->sortable(),
                TextColumn::make('type')->sortable()->searchable()->label('Diet Type'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                //ReplicateAction::make(),

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
            'index' => Pages\ListDiets::route('/'),
            'create' => Pages\CreateDiet::route('/create'),
            'edit' => Pages\EditDiet::route('/{record}/edit'),
        ];
    }
}
