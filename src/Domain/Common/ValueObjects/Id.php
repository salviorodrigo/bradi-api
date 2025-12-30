<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\ValueObjects;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\ValueObject;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;

final class Id extends ValueObject
{
    public static string $fieldName = 'id';

    private function __construct(public readonly mixed $value) {}

    public static function parse(mixed $rawData): Result
    {
        $validationService = new ValidationService([
            new IsStringValidator(self::$fieldName),
            new NotNullValidator(self::$fieldName),
        ]);
        $validationServiceResponse = $validationService->verify($rawData);
        if ($validationServiceResponse->isSuccess()) {
            return Result::makeSuccess(new Id($rawData));
        }

        return $validationServiceResponse;
    }
}
