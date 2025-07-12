<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TestCartWidget extends ChartWidget
{
    protected static ?string $heading = 'Test Chart';

    protected int | string | array $columnSpan = 1;

    // protected static string $color = 'success';

    protected function getData(): array
    {
        $data = Trend::model(Post::class)
            ->between(
                start: now()->subMonth(6),
                end: now(),
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
