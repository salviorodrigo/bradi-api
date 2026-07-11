<?php

declare(strict_types=1);

namespace BradiApi\Tests\Datasets;

use BradiApi\Tests\Datasets\Protocols\Dataset;
use Error;
use Exception;

class Exceptions extends Dataset
{
    public array $dataset = [
        'exceptions' => [],
    ];

    public function __construct()
    {
        $this->dataset['exceptions'] = [
            'error' => new Error('Generic error'),
            'exception' => new Exception('Generic exception'),
        ];
    }

    public static function getDataset(): array
    {
        return (new self)->dataset;
    }
}
