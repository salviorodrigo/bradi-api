<?php

declare(strict_types=1);

namespace BradiApi\Tests\Doubles\Factories;

use BradiApi\Tests\Datasets\Arrays;
use BradiApi\Tests\Datasets\Booleans;
use BradiApi\Tests\Datasets\CNPJs;
use BradiApi\Tests\Datasets\CPFs;
use BradiApi\Tests\Datasets\DFes;
use BradiApi\Tests\Datasets\Emails;
use BradiApi\Tests\Datasets\Empties;
use BradiApi\Tests\Datasets\Exceptions;
use BradiApi\Tests\Datasets\NonStringable;
use BradiApi\Tests\Datasets\Numerics;
use BradiApi\Tests\Datasets\Strings;
use BradiApi\Tests\Datasets\Uuids;
use BradiApi\Tests\Datasets\Xmls;
use InvalidArgumentException;

final class DatasetFactory
{
    public array $dataset = [];

    private array $datasetClasses = [
        Arrays::class,
        Booleans::class,
        CNPJs::class,
        CPFs::class,
        DFes::class,
        Emails::class,
        Empties::class,
        Exceptions::class,
        NonStringable::class,
        Numerics::class,
        Strings::class,
        Uuids::class,
        Xmls::class,
    ];

    private function __construct()
    {
        foreach ($this->datasetClasses as $datasetClass) {
            $this->dataset += $datasetClass::getDataset();
        }
    }

    public static function generateByKeyStrings(string ...$keyStrings): array
    {
        $baseDataset = (new self)->dataset;
        $resultDataset = [];
        foreach ($keyStrings as $keyString) {
            $resultDataset += self::filterByKeyString($keyString, $baseDataset);
        }

        return $resultDataset;
    }

    private static function filterByKeyString(string $keyString, array $dataset): array
    {

        $pathKeys = explode('.', $keyString);
        foreach ($pathKeys as $pathKey) {
            $dataset = $dataset[$pathKey];
        }

        if (empty($dataset)) {
            throw new InvalidArgumentException("Dataset not found for key string: {$keyString}");
        }

        if (is_array($dataset)) {
            $dataset = self::flattenDataset($dataset, $keyString);
        } else {
            if (json_validate($dataset) && ! is_numeric($dataset)) {
                $dataset = json_decode($dataset, true);
            }

            $dataset = [$keyString => $dataset];
        }

        return $dataset;
    }

    private static function flattenDataset(array $dataset, string $prefix = ''): array
    {
        $flattened = [];
        foreach ($dataset as $key => $value) {
            if ($prefix !== '') {
                $key = $prefix . '.' . $key;
            }
            if (is_array($value)) {
                $flattened += self::flattenDataset($value, $key);
            } else {
                if (is_string($value) && json_validate($value)) {
                    if (! is_numeric($value)) {
                        $value = json_decode($value, true);
                    }
                }

                $flattened[$key] = $value;
            }
        }

        return $flattened;
    }
}
