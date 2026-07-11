<?php

declare(strict_types=1);

namespace BradiApi\Tests\Datasets;

use BradiApi\Tests\Datasets\Protocols\Dataset;

class CPFs extends Dataset
{
    public array $dataset = [
        'cpfs' => [
            'valid' => [
                'standard' => '52998224725',
            ],
            'invalid' => [
                'masked' => '529.982.247-25',
                'repeated_digits' => [
                    'zeros' => '00000000000',
                    'ones' => '11111111111',
                    'twos' => '22222222222',
                    'threes' => '33333333333',
                    'fours' => '44444444444',
                    'fives' => '55555555555',
                    'sixes' => '66666666666',
                    'sevens' => '77777777777',
                    'eights' => '88888888888',
                    'nines' => '99999999999',
                ],
                'incorrect_checksum' => '45678912355',
                'wrong_size' => [
                    'too_short' => '1234567890',
                    'too_long' => '123456789012',
                ],
            ],
        ],
    ];

    public static function getDataset(): array
    {
        return (new self)->dataset;
    }
}
