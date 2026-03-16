<?php

declare(strict_types=1);

namespace BradiNfeApi\Tests\Datasets;

use BradiNfeApi\Tests\Datasets\Protocols\Dataset;

class Emails extends Dataset
{
    public array $dataset = [
        'emails' => [
            'valid' => [
                'standard' => 'user@example.com',
                'with_plus' => 'user+filter@gmail.com',
                'subdomain' => 'admin@mail.sub.domain.org',
            ],
            'invalid' => [
                'missing_at' => 'userExample.com',
                'missing_domain' => 'user@',
                'with_spaces' => 'user @example.com',
            ],
        ],
    ];

    public static function getDataset(): array
    {
        return (new self)->dataset;
    }
}
