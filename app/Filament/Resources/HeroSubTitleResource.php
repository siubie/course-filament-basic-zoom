<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSubTitleResource\Pages;
use App\Filament\Resources\HeroSubTitleResource\RelationManagers;
use App\Models\HeroSubTitle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeroSubTitleResource extends Resource
{
    protected static ?string $model = HeroSubTitle::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    // Add grouping to the Filament menu
    protected static ?string $navigationGroup = 'Heroes Management';

    // Order the navigation menu inside the group
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('text')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('hero_id')
                    ->relationship('hero', 'title')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('text')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hero.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListHeroSubTitles::route('/'),
            // 'create' => Pages\CreateHeroSubTitle::route('/create'),
            // 'edit' => Pages\EditHeroSubTitle::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
