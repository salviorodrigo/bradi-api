<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\ValueObjects;

use BradiNfeApi\Common\Services\ValidationService;
use BradiNfeApi\Common\ValueObjects\Result;
use BradiNfeApi\Domain\Common\Protocols\ValueObject;
use BradiNfeApi\Domain\Common\Validators\IsStringValidator;
use BradiNfeApi\Domain\Common\Validators\NotNullValidator;

final class Id extends ValueObject
{
    public static string $fieldURI = 'id';

    private function __construct(public readonly mixed $value) {}

    public static function parse(mixed $rawData, string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        $fieldURI = $parentFieldURI == '' ? self::$fieldURI : $parentFieldURI . '.' . self::$fieldURI;
        $validationService = new ValidationService([
            IsStringValidator::class => [],
            NotNullValidator::class => [],
        ], $fieldURI, $method);

        $validationServiceResponse = $validationService->verify($rawData);
        if ($validationServiceResponse->isSuccess()) {
            return Result::makeSuccess(new Id($rawData));
        }

        return $validationServiceResponse;
    }
}
