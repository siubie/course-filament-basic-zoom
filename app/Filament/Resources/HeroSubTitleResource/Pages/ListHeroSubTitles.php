<?php

namespace App\Filament\Resources\HeroSubTitleResource\Pages;

use App\Filament\Resources\HeroSubTitleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHeroSubTitles extends ListRecords
{
    protected static string $resource = HeroSubTitleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
