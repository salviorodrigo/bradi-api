<?php

declare(strict_types=1);

namespace BradiApi\Tests\Datasets;

use BradiApi\Tests\Datasets\Protocols\Dataset;

class Strings extends Dataset
{
    public array $dataset = [
        'strings' => [
            'basic' => [
                'single_space' => ' ',
                'simple_word' => 'Word',
                'alphanumeric' => 'Word123',
                'long' => null,
            ],
            'special_characters' => [
                'accented_chars' => 'Ação Épica Ü',
                'symbols' => '!@#$%^&*()_+',
                'emoji' => '🚀 Test ✨',
            ],
        ],
    ];

    public function __construct()
    {
        $this->dataset['strings']['basic']['long'] = str_repeat('Word', 100);
    }

    public static function getDataset(): array
    {
        return (new self)->dataset;
    }
}
