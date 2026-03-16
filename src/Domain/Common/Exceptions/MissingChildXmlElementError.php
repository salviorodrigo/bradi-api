<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Exceptions;

use BradiNfeApi\Common\ValueObjects\Detail;
use BradiNfeApi\Common\ValueObjects\Error;
use BradiNfeApi\Common\ValueObjects\Input;
use BradiNfeApi\Domain\Common\Protocols\UnprocessableEntityError;
use InvalidArgumentException;

final class MissingChildXmlElementError extends UnprocessableEntityError
{
    public function __construct(string $field, string $source, mixed $input, array $requiredChildElementsNames)
    {
        $missingElementsNames = array_diff($requiredChildElementsNames, $input);
        $requiredChildElementsNamesString = $this->getRequiredChildElementsNamesString($requiredChildElementsNames);
        $missingChildElementsNamesString = $this->getMissingChildElementsNamesString($missingElementsNames);
        $message = "this xml element should have the following child elements: {$requiredChildElementsNamesString}.  {$missingChildElementsNamesString} is missing.";
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }

    private function getRequiredChildElementsNamesString(array $requiredChildElementsNames): string
    {
        switch (count($requiredChildElementsNames)) {
            case 0:
                throw new InvalidArgumentException('At least one required children element tag must be informed.');
            case 1:
                return $requiredChildElementsNames[0];

            default:
                $lastRequiredChildElementName = array_pop($requiredChildElementsNames);

                return implode(', ', $requiredChildElementsNames) . ' and ' . $lastRequiredChildElementName;
        }
    }

    private function getMissingChildElementsNamesString(array $missingChildElementsNames): string
    {
        switch (count($missingChildElementsNames)) {
            case 0:
                throw new InvalidArgumentException('At least one missing required children element name must be informed.');
            case 1:
                return $missingChildElementsNames[0];

            default:
                $lastMissingChildElementName = array_pop($missingChildElementsNames);

                return implode(', ', $missingChildElementsNames) . ' and ' . $lastMissingChildElementName;
        }
    }
}
