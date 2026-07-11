<?php

declare(strict_types=1);

namespace BradiApi\Tests\Datasets;

use BradiApi\Tests\Datasets\Protocols\Dataset;

class Empties extends Dataset
{
    public array $dataset = [
        'empties' => [
            'string' => [
                'simple' => '',
                'zero_string' => '0',
            ],
            'number' => [
                'zero' => 0,
                'float' => 0.0,
            ],
            'null' => [
                'value' => null,
            ],
            'array' => [
                'empty' => [],
            ],
        ],
    ];

    public static function getDataset(): array
    {
        return (new self)->dataset;
    }
}
