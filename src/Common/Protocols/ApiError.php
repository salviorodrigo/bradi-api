<?php

declare(strict_types=1);

namespace BradiNfeApi\Common\Protocols;

use BradiNfeApi\Common\ValueObjects\Detail;
use InvalidArgumentException;

abstract class ApiError
{
    public string $type;
    public string $status;
    public string $title;
    public string $description;
    public array $details;

    public function __construct(Detail $detail)
    {
        $this->details[] = $detail;
    }

    public function merge(ApiError $apiError): void
    {
        if ($this->type !== $apiError->type) {
            throw new InvalidArgumentException("Cannot merge ApiErrors with different types ('{$this->type}' and '{$apiError->type}').");
        }

        foreach ($apiError->details as $errorDetail) {
            if ($this->alreadyExistsErrorInField($errorDetail->field)) {
                $existingDetailIndex = $this->getErrorDetailIndexByField($errorDetail->field);
                $this->details[$existingDetailIndex]->merge($errorDetail);

            } else {
                $this->details[] = $errorDetail;
            }
        }
    }

    protected function alreadyExistsErrorInField(string $field): bool
    {
        foreach ($this->details as $errorDetail) {
            if ($errorDetail->field === $field) {
                return true;
            }
        }

        return false;
    }

    protected function getErrorDetailIndexByField(string $field): int
    {
        foreach ($this->details as $index => $errorDetail) {
            if ($errorDetail->field === $field) {
                return $index;
            }
        }

        throw new InvalidArgumentException("ErrorDetail with field '{$field}' not found.");
    }
}

/** ApiError response example
 *
 * {
 * "type": "namespace.to.error_type",
 * "status": 403,
 * "title": "Validation Error",
 * "description": "a data validation error occurs.",
 * "detail": [
 *     {
 *         "field": "xmlString.nfeProc.NFe.infNFe.det[1].prod.qCom",
 *         "errors": [
 *             {
 *                 "source": // "ClassName::methodName",
 *                 "input": "(dataType) {jsonString}""
 *                 "messages": [
 *                     "must be a positive number."
 *                 ]
 *             }
 *         ]
 *     }
 * ],
 *     }
**/

// TODO Make test file.
