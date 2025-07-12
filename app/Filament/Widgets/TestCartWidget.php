<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class TestCartWidget extends ChartWidget
{
    protected static ?string $heading = 'Test Chart';

    protected int | string | array $columnSpan = 1;

    // protected static string $color = 'success';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [ 21, 32, 45, 89],
                    'backgroundColor' => [
                        'rgba(255, 99, 132)',
                        'rgba(75, 192, 192)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                    ]
                ],
            ],
            'labels' => ['Red', 'Green', 'Blue', 'Yellow'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
