<?php

declare(strict_types=1);

namespace BradiNfeApi\Tests\Datasets;

use BradiNfeApi\Tests\Datasets\Protocols\Dataset;
use stdClass;

class NonStringable extends Dataset
{
    public array $dataset = [
        'non_stringable' => [
            'boolean' => [
                'true' => true,
                'false' => false,
            ],
            'null' => [
                'value' => null,
            ],
            'object' => null,
            'array' => [
                'empty' => null,
                'indexed' => null,
            ],
        ],
    ];

    public function __construct()
    {
        $this->dataset['non_stringable']['object'] = json_encode(new stdClass);
        $this->dataset['non_stringable']['array']['empty'] = json_encode([]);
        $this->dataset['non_stringable']['array']['indexed'] = json_encode([1, 2, 3]);
    }

    public static function getDataset(): array
    {
        return (new self)->dataset;
    }
}
