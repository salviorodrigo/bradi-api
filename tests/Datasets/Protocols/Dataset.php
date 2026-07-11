<?php

declare(strict_types=1);

namespace BradiApi\Tests\Datasets\Protocols;

abstract class Dataset
{
    public array $dataset;

    abstract public static function getDataset(): array;
}
