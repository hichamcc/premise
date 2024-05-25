<?php

namespace App\Filament\Widgets;

use App\Models\Diet;
use App\Models\User;
use App\Models\Workout;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class userWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(' Users' , User::count())
                ->descriptionIcon('heroicon-o-user-group' )
                ->description('users that have joind')
            ->chart([1,3,5,2,6])
            ->color('info'),
            Stat::make('Diets' , Diet::count())
                ->descriptionIcon('heroicon-o-list-bullet' )
                ->description('Total diets')
                ->chart([5,3,1,2,4])
                ->color('warning'),
            Stat::make('Workouts' , Workout::count())
                ->descriptionIcon('heroicon-o-trophy' )
                ->description('Total workouts video')
                ->chart([1,5,1,2,6])
                ->color('danger')
        ];
    }


}
