<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New Users',User::count())
            ->description('New users that have joined')
            ->descriptionIcon('heroicon-s-user-group',IconPosition::Before)
            ->chart([10,15,5,35,11,66,22,100])
            ->color('success')
        ];
    }
}
