<?php

declare(strict_types=1);

namespace BradiApi\Tests\Datasets;

use BradiApi\Tests\Datasets\Protocols\Dataset;

class Arrays extends Dataset
{
    public array $dataset = [
        'arrays' => [
            'simple' => [
                'numeric_indexed' => null,
                'string_list' => null,
            ],
            'associative' => [
                'single_pair' => null,
                'multiple_pairs' => null,
            ],
            'nested' => [
                'multidimensional' => null,
            ],
        ],
    ];

    public function __construct()
    {
        $this->dataset['arrays']['simple']['numeric_indexed'] = json_encode([1, 2, 3]);
        $this->dataset['arrays']['simple']['string_list'] = json_encode(['apple', 'banana', 'orange']);
        $this->dataset['arrays']['associative']['single_pair'] = json_encode(['id' => 1]);
        $this->dataset['arrays']['associative']['multiple_pairs'] = json_encode([
            'name' => 'John',
            'role' => 'admin',
            'active' => true,
        ]);
        $this->dataset['arrays']['nested']['multidimensional'] = json_encode([
            'users' => [
                ['id' => 1, 'name' => 'User A'],
                ['id' => 2, 'name' => 'User B'],
            ],
        ]);
    }

    public static function getDataset(): array
    {
        return (new self)->dataset;
    }
}
