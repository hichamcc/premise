<?php

namespace App\Filament\Resources\DietPlanResource\Pages;

use App\Filament\Resources\DietPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDietPlan extends CreateRecord
{
    protected static string $resource = DietPlanResource::class;
    protected static bool $canCreateAnother = false;
    protected static bool $canDelete = false;



}
