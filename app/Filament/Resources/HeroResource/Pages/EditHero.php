<?php

namespace App\Filament\Resources\HeroResource\Pages;

use App\Filament\Resources\HeroResource;
use App\Models\Hero;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHero extends EditRecord
{
    protected static string $resource = HeroResource::class;

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

    protected function beforeSave(): void
    {
        // Runs before the form fields are saved to the database.
        // dd($this->data);
        //if is_active is true then set all other records to false
        if ($this->data['is_active']) {
            //update all hero that id is not in data to inactive
            Hero::where('id', '!=', $this->data['id'])->update(['is_active' => 0]);
        }
    }
}
