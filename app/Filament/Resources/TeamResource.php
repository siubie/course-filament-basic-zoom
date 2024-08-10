<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Filament\Resources\TeamResource\RelationManagers;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Team Details')
                    ->description('Isikan Detail Team Section yang ingin di isi')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('position')
                            ->required()
                            ->maxLength(255),
                    ]),

                Section::make('Team Socials')
                    ->schema([
                        Repeater::make('teamSocials')
                            ->relationship()
                            ->schema([
                                Split::make([
                                    Forms\Components\Select::make('type')
                                        ->options([
                                            'facebook' => 'Facebook',
                                            'twitter' => 'Twitter',
                                            'linkedin' => 'Linkedin',
                                            'instagram' => 'Instagram',
                                        ])
                                        ->native(false)
                                        ->required(),
                                    Forms\Components\TextInput::make('link')
                                        ->required()
                                        ->maxLength(255),
                                ])
                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    // ->description(fn (Team $record): string => $record->teamSocials->pluck('name')->join(', ')),
                    ->description(fn(Team $record): string => $record->teamSocials->pluck('link')->join(','))->wrap(),
                Tables\Columns\TextColumn::make('position')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->reorderable('sort')
            ->defaultSort('sort', 'asc')
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
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
