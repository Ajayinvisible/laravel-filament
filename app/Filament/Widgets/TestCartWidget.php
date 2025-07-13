<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TestCartWidget extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Test Chart';

    protected int | string | array $columnSpan = 1;

    // protected static string $color = 'success';

    protected function getData(): array
    {
        $startDate = $this->filters['startDate'];
        $endDate = $this->filters['endDate'];
        $data = Trend::model(Post::class)
            ->between(
                start: $startDate ? Carbon::parse($startDate) : now()->subMonth(6),
                end: $endDate ? Carbon::parse($endDate) : now()->subMonth(6),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
