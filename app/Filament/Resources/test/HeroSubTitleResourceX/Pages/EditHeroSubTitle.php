<?php

namespace App\Filament\Resources\HeroSubTitleResource\Pages;

use App\Filament\Resources\HeroSubTitleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHeroSubTitlesas extends EditRecord
{
    protected static string $resource = HeroSubTitleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    //redirect to index page after edit
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
