<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroResource\Pages;
use App\Filament\Resources\HeroResource\RelationManagers;
use App\Models\Hero;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    // Add grouping to the Filament menu
    protected static ?string $navigationGroup = 'Heroes Management';

    // Order the navigation menu inside the group
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Hero Details')
                    ->description('Isikan Detail Hero Section yang ingin di isi')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('description')
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
                                ->inline(false)
                                ->required(),
                        ]),
                    ]),
                Section::make('Hero Sub Titles')
                    ->schema([
                        Repeater::make('heroSubTitles')
                            ->relationship()
                            ->schema([
                                TextInput::make('text')
                                    ->required()
                            ])
                            ->cloneable(true)
                            ->grid(2)
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('title')
                    ->wrap()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->wrap()
                    ->html()
                    ->searchable(),
                // Tables\Columns\IconColumn::make('is_active')
                //     ->boolean(),
                TextColumn::make('heroSubTitles.text')
                    ->badge(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->afterStateUpdated(function ($record, $state) {
                        // dd($record, $state);
                        if ($state) {
                            //set all other records to false
                            Hero::where('id', '!=', $record->id)->update(['is_active' => false]);
                        }
                    })
            ])
            ->filters([
                //
                Filter::make('is_active')
                    ->query(fn(Builder $query): Builder => $query->where('is_active', true))
                    ->label('Active')
                    ->toggle(),

                SelectFilter::make('is_active')
                    ->multiple()
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->attribute('is_active'),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
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
