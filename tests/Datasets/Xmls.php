<?php

namespace BradiApi\Tests\Datasets;

use BradiApi\Tests\Datasets\Protocols\Dataset;

class Xmls extends Dataset
{
    public array $dataset = [
        'xmls' => [
            'valid' => [
                'standard' => [
                    'simple' => '<root><item>itemValue</item></root>',
                    'self_closing' => [
                        'trim_spaces' => '<item id="1"/>',
                        'with_space' => '<item id="1" />',
                    ],
                    'collection' => '<root><items><item id="1">1</item><item id="2">2</item></items></root>',
                ],
                'with_attribute' => [
                    'single' => '<node id="1">content</node>',
                    'multiple' => '<node id="1" status="active" type="generic">content</node>',
                ],
            ],
            'invalid' => [
                'malformed' => '<root><unclosed>',
                'mismatch' => '<open>close</wrong>',
                'empty' => [
                    'simple' => '<root></root>',
                ],
            ],
        ],
    ];

    public static function getDataset(): array
    {
        return (new self)->dataset;
    }
}
