<?php

declare(strict_types=1);

namespace BradiApi\Domain\Common\ValueObjects;

use BradiApi\Domain\Common\Protocols\ValueObject;
use BradiApi\Domain\Common\Services\ValidationService;
use BradiApi\Domain\Common\Validators\IsStringValidator;
use BradiApi\Domain\Common\Validators\NotNullValidator;

final class Id extends ValueObject
{
    public static string $fieldURI = 'id';

    private function __construct(public readonly mixed $value) {}

    public static function parse(mixed $rawData, string $parentFieldURI = '', string $method = __METHOD__): Result
    {
        $fieldURI = $parentFieldURI == '' ? self::$fieldURI : $parentFieldURI . '.' . self::$fieldURI;
        $validationService = new ValidationService($fieldURI, $method)
            ->addValidator(new IsStringValidator)
            ->addValidator(new NotNullValidator);
        $validationServiceResponse = $validationService->verify($rawData);
        if ($validationServiceResponse->isSuccess()) {
            return Result::makeSuccess(new Id($rawData));
        }

        return $validationServiceResponse;
    }
}
