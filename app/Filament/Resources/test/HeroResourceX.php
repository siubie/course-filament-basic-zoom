<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroResource\Pages;
use App\Filament\Resources\HeroResource\RelationManagers;
use App\Models\Hero;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class HeroResourceX extends Resource
{
    protected static ?string $model = Hero::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Hero Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Hero Information')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('description')
                            ->required()
                            ->maxLength(255),
                        Split::make([
                            Forms\Components\TextInput::make('link1')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('link2')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Toggle::make('is_active')
                                ->required()
                                ->inline(false),
                        ]),
                    ]),
                Section::make('Hero Sub Titles')->schema([
                    Repeater::make('heroSubTitles')
                        ->relationship()
                        ->schema([
                            Forms\Components\TextInput::make('text')
                                ->required()
                                ->maxLength(255),
                        ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->afterStateUpdated(function ($record, $state) {
                        // If the record is being activated, deactivate all other records.
                        if ($state) {
                            $record->newQuery()
                                ->whereKeyNot($record->getKey())
                                ->update(['is_active' => false]);
                        }
                    }),
                TextColumn::make('heroSubTitles.text')
                    ->formatStateUsing(function ($record, $state) {
                        return new HtmlString($record->heroSubTitles->pluck('text')->implode('</br>'));
                    }),
                TextColumn::make('heroSubTitles.text')
                    ->badge()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListHeroes::route('/'),
            'create' => Pages\CreateHero::route('/create'),
            'edit' => Pages\EditHero::route('/{record}/edit'),
        ];
    }
}
