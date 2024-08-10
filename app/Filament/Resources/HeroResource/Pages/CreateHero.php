<?php

namespace App\Filament\Resources\HeroResource\Pages;

use App\Filament\Resources\HeroResource;
use App\Models\Hero;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHero extends CreateRecord
{
    protected static string $resource = HeroResource::class;

    //redirect to index page after edit
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    //add before create hooks
    protected function beforeCreate()
    {
        // dd($this->data);
        //if is_active is true then set all other records to false
        if ($this->data['is_active']) {
            //update all hero to inactive
            Hero::query()->update(['is_active' => false]);
        }
    }
}
