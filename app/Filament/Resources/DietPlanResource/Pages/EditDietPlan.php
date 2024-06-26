<?php

namespace App\Filament\Resources\DietPlanResource\Pages;

use App\Filament\Resources\DietPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDietPlan extends EditRecord
{
    protected static string $resource = DietPlanResource::class;
    protected static bool $canDelete = false;



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
