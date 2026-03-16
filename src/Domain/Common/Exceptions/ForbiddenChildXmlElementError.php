<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Exceptions;

use BradiNfeApi\Common\ValueObjects\Detail;
use BradiNfeApi\Common\ValueObjects\Error;
use BradiNfeApi\Common\ValueObjects\Input;
use BradiNfeApi\Domain\Common\Protocols\UnprocessableEntityError;
use InvalidArgumentException;

final class ForbiddenChildXmlElementError extends UnprocessableEntityError
{
    /**
     * @param  array<string>  $allowedChildElementsNames
     * */
    public function __construct(string $field, string $source, mixed $input, array $allowedChildElementsNames)
    {
        foreach ($allowedChildElementsNames as $allowedChildElementName) {
            if (! is_string($allowedChildElementName)) {
                throw new InvalidArgumentException('allowedChildElementsNames array must contain only strings. ' . gettype($allowedChildElementName) . ' given.');
            }
        }

        foreach ($input as $providedChildElementName) {
            if (! is_string($providedChildElementName)) {
                throw new InvalidArgumentException('input must be an array of strings. ' . gettype($providedChildElementName) . ' given.');
            }
        }

        $allowedChildElementsNamesString = $this->getAllowedChildElementsNamesString($allowedChildElementsNames);
        $providedChildElementsNamesString = $this->getProvidedChildElementsNamesString($input);
        $message = "this xml element only allows following child elements: {$allowedChildElementsNamesString}. {$providedChildElementsNamesString} given.";
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }

    private function getAllowedChildElementsNamesString(array $allowedChildElementsNames): string
    {
        switch (count($allowedChildElementsNames)) {
            case 0:
                throw new InvalidArgumentException('allowedChildElementsNames array must have at least one element.');
            case 1:
                return $allowedChildElementsNames[0];

            default:
                $lastAllowedChildElementName = array_pop($allowedChildElementsNames);
                $allowedChildElementsNamesAsString = implode(', ', $allowedChildElementsNames);

                return $allowedChildElementsNamesAsString . ' or ' . $lastAllowedChildElementName . '.';
        }
    }

    private function getProvidedChildElementsNamesString(array $providedChildElementsNames): string
    {
        switch (count($providedChildElementsNames)) {
            case 0:
                throw new InvalidArgumentException('input array must have at least one element name.');
            case 1:
                return $providedChildElementsNames[0];

            default:
                $lastProvidedChildElementName = array_pop($providedChildElementsNames);
                $providedChildElementsNamesAsString = implode(', ', $providedChildElementsNames);

                return $providedChildElementsNamesAsString . ' and ' . $lastProvidedChildElementName . '.';
        }
    }
}
