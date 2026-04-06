<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Protocols;

use BradiNfeApi\Domain\Common\ValueObjects\Detail;
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

    public function merge(ApiError $outerError): self
    {
        if ($this->type !== $outerError->type) {
            throw new InvalidArgumentException("Cannot merge ApiErrors with different types ('{$this->type}' and '{$outerError->type}').");
        }

        foreach ($outerError->details as $errorDetail) {
            if ($this->alreadyExistsErrorInField($errorDetail)) {
                $existingDetailIndex = $this->getErrorDetailIndexByField($errorDetail->field);
                $this->details[$existingDetailIndex]->merge($errorDetail);

                continue;
            }

            $this->details[] = $errorDetail;
        }

        return $this;
    }

    private function alreadyExistsErrorInField(Detail $outerDetail): bool
    {
        foreach ($this->details as $errorDetail) {
            if ($errorDetail->field === $outerDetail->field
                && $errorDetail->input === $outerDetail->input
                && $errorDetail->source === $outerDetail->source) {
                return true;
            }
        }

        return false;
    }

    private function getErrorDetailIndexByField(Detail $outerDetail): int
    {
        foreach ($this->details as $index => $errorDetail) {
            if ($errorDetail->field === $outerDetail->field
                && $errorDetail->input === $outerDetail->input
                && $errorDetail->source === $outerDetail->source) {
                return $index;
            }
        }

        throw new InvalidArgumentException("No error detail found for field '{$outerDetail->field}' with input '{$outerDetail->input}' and source '{$outerDetail->source}'.");
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
 *         "source": // "ClassName::methodName",
 *         "input": "(dataType) {jsonString}",
 *         "messages": [
 *             "must be a positive number."
 *         ]
 *     },
 *     {
 *         "field": "xmlString.nfeProc.NFe.infNFe.det[1].prod.xProc",
 *         "source": // "ClassName::methodName",
 *         "input": "(dataType) {jsonString}",
 *         "messages": [
 *             "leading spaces are not allowed."
 *         ]
 *     }
 * ]}
**/

// TODO Make test file.
