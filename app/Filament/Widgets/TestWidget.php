<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    use InteractsWithPageFilters;
    protected function getStats(): array
    {
        // $startDate = $this->filters['startDate'];
        // $endDate = $this->filters['endDate'];
        return [
            Stat::make(
                'New Users',
                User::
                    // when(
                    //     $startDate,
                    //     fn($query) => $query->where('created_at', '>', $startDate)
                    // )
                    //     ->when(
                    //         $endDate,
                    //         fn($query) => $query->where('created_at', '<', $endDate)
                    //     )
                    //     ->
                    count()
            )
                ->description('New users that have joined')
                ->descriptionIcon('heroicon-s-user-group', IconPosition::Before)
                ->chart([10, 15, 5, 35, 11, 66, 22, 100])
                ->color('success')
        ];
    }
}
