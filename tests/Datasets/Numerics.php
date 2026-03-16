<?php

declare(strict_types=1);

namespace BradiNfeApi\Tests\Datasets;

use BradiNfeApi\Tests\Datasets\Protocols\Dataset;

class Numerics extends Dataset
{
    public array $dataset = [
        'numerics' => [
            'integer' => [
                'decimal' => 42,
                'negative' => -42,
                'thousands' => 1_000,
                'large' => PHP_INT_MAX,
                'small' => PHP_INT_MIN,
            ],
            'float' => [
                'standard' => 3.1415,
                'negative' => -1.5,
                'scientific_e' => 1.2e3,
            ],
            'strings' => [
                'integer' => '123',
                'float' => '12.3',
                'scientific' => '1.2e3',
                'negative' => '-123',
                'thousands' => '1_000',
            ],
        ],
    ];

    public static function getDataset(): array
    {
        return (new self)->dataset;
    }
}
