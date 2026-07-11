<?php

namespace BradiApi\Tests\Datasets;

use BradiApi\Tests\Datasets\Protocols\Dataset;

class Uuids extends Dataset
{
    public array $dataset = [
        'uuids' => [
            'valid' => [
                'hyphenated' => [
                    'v4' => 'f47ac10b-58cc-4372-a567-0e02b2c3d479',
                    'v7' => '018b3941-2c00-7544-a957-3f9f4a012345',
                ],
                'plain' => [
                    'v4' => 'f47ac10b58cc4372a5670e02b2c3d479',
                ],
            ],
            'invalid' => [
                'format' => [
                    'empty' => '',
                    'short' => 'f47ac10b-58cc-4372-a567',
                ],
                'character' => [
                    'non_hex' => 'g47ac10b-58cc-4372-a567-0e02b2c3d479',
                ],
            ],
        ],
    ];

    public static function getDataset(): array
    {
        return (new self)->dataset;
    }
}
