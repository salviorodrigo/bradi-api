<?php

declare(strict_types=1);

namespace BradiApi\Tests\Datasets;

use BradiApi\Tests\Datasets\Protocols\Dataset;

class Booleans extends Dataset
{
    public array $dataset = [
        'booleans' => [
            'true' => true,
            'false' => false,
        ],
    ];

    public static function getDataset(): array
    {
        return (new self)->dataset;
    }
}
