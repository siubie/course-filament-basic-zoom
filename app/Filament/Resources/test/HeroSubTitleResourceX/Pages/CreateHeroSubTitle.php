<?php

namespace App\Filament\Resources\HeroSubTitleResource\Pages;

use App\Filament\Resources\HeroSubTitleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHeroSubTitleasdad extends CreateRecord
{
    protected static string $resource = HeroSubTitleResource::class;

    //redirect to index page after edit
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
