<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\ValueObjects;

use BradiNfeApi\Common\Result;
use BradiNfeApi\Domain\Common\Protocols\ValueObject;
use BradiNfeApi\Domain\Common\Services\ValidationService;
use BradiNfeApi\Domain\Common\Validators\IsCNPJValidator;
use BradiNfeApi\Domain\Common\Validators\IsNumericValidator;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;
use BradiNfeApi\Domain\Common\Validators\StringLengthValidator;

final class CNPJ extends ValueObject
{
    public static string $fieldName = 'cnpj';

    private function __construct(public readonly mixed $value) {}

    public static function parse(mixed $rawData): Result
    {

        $validationService = new ValidationService([
            new NotNullValidator(self::$fieldName),
            new IsStringValidator(self::$fieldName),
            new IsNumericValidator(self::$fieldName),
            new StringLengthValidator(self::$fieldName, 14),
            new IsCNPJValidator(self::$fieldName),
        ]);
        $validationServiceResponse = $validationService->verify($rawData);
        if ($validationServiceResponse->isSuccess()) {
            return Result::makeSuccess(new self($rawData));
        }

        return $validationServiceResponse;
    }
}
