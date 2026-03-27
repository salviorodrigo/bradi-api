<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\UnprocessableEntityError;
use BradiNfeApi\Domain\Common\ValueObjects\Detail;
use BradiNfeApi\Domain\Common\ValueObjects\Error;
use BradiNfeApi\Domain\Common\ValueObjects\Input;
use InvalidArgumentException;

final class ForbiddenXmlElementAttributesError extends UnprocessableEntityError
{
    /**
     * @param  array<string>  $allowedAttributesKeys
     * */
    public function __construct(string $field, string $source, mixed $input, array $allowedAttributesKeys)
    {
        foreach ($allowedAttributesKeys as $attributeKey) {
            if (! is_string($attributeKey)) {
                throw new InvalidArgumentException('allowedAttributesKeys array must contain only strings. ' . gettype($attributeKey) . ' given.');
            }
        }

        foreach ($input as $providedAttributeKey) {
            if (! is_string($providedAttributeKey)) {
                throw new InvalidArgumentException('input must be an array of strings. ' . gettype($providedAttributeKey) . ' given.');
            }
        }

        $allowedAttributesKeysString = $this->getAllowedAttributesKeysString($allowedAttributesKeys);
        $providedAttributesKeysString = $this->getProvidedAttributesKeysString($input);
        $message = "this xml element only allows following attributes: {$allowedAttributesKeysString}. {$providedAttributesKeysString} given.";
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }

    private function getAllowedAttributesKeysString(array $allowedAttributesKeys): string
    {
        switch (count($allowedAttributesKeys)) {
            case 0:
                throw new InvalidArgumentException('allowedAttributesKeys array must have at least one element.');
            case 1:
                return $allowedAttributesKeys[0];

            default:
                $lastAllowedAttributeKey = array_pop($allowedAttributesKeys);
                $allowedAttributesKeysAsString = implode(', ', $allowedAttributesKeys);

                return $allowedAttributesKeysAsString . ' or ' . $lastAllowedAttributeKey . '.';
        }
    }

    private function getProvidedAttributesKeysString(array $providedAttributesKeys): string
    {
        switch (count($providedAttributesKeys)) {
            case 0:
                throw new InvalidArgumentException('input array must have at least one element name.');
            case 1:
                return $providedAttributesKeys[0];

            default:
                $lastProvidedAttributeKey = array_pop($providedAttributesKeys);
                $providedAttributesKeysAsString = implode(', ', $providedAttributesKeys);

                return $providedAttributesKeysAsString . ' and ' . $lastProvidedAttributeKey . '.';
        }
    }
}
