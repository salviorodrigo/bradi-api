<?php

declare(strict_types=1);

namespace BradiNfeApi\Tests\Datasets;

use BradiNfeApi\Tests\Datasets\Protocols\Dataset;

class CNPJs extends Dataset
{
    public array $dataset = [
        'cnpjs' => [
            'valid' => [
                'standard' => '12345678000190',
            ],
            'invalid' => [
                'masked' => '12.345.678/0001-90',
                'repeated_digits' => [
                    'zeros' => '00000000000000',
                    'ones' => '11111111111111',
                    'twos' => '22222222222222',
                    'threes' => '33333333333333',
                    'fours' => '44444444444444',
                    'fives' => '55555555555555',
                    'sixes' => '66666666666666',
                    'sevens' => '77777777777777',
                    'eights' => '88888888888888',
                    'nines' => '99999999999999',
                ],
                'incorrect_checksum' => [
                    '12345678000100',
                ],
                'wrong_size' => [
                    'too_long' => '123456780001900',
                    'too_short' => '1234567800019',
                ],
            ],
        ],
    ];

    public static function getDataset(): array
    {
        return (new self)->dataset;
    }
}
