<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsWidget extends BaseWidget
{
    public ?User $record;
    protected function getStats(): array
    {
        return [
            Stat::make("User: {$this->record->name}", $this->record->posts()->count())
                ->description("Number of post by user: {$this->record->posts()->count()}")
                ->color('success')
                ->descriptionIcon('heroicon-o-newspaper', IconPosition::Before)
        ];
    }
}
