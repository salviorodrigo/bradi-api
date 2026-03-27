<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\UnprocessableEntityError;
use BradiNfeApi\Domain\Common\ValueObjects\Detail;
use BradiNfeApi\Domain\Common\ValueObjects\Error;
use BradiNfeApi\Domain\Common\ValueObjects\Input;
use InvalidArgumentException;

final class MissingXmlElementAttributeError extends UnprocessableEntityError
{
    public function __construct(string $field, string $source, mixed $input, array $requiredElementsAttributes)
    {
        $missingElementsNames = array_diff($requiredElementsAttributes, $input);
        $requiredElementsAttributesString = $this->getRequiredElementsAttributesString($requiredElementsAttributes);
        $missingElementsAttributesString = $this->getMissingElementsAttributesString($missingElementsNames);
        $message = "this xml element should have the following attributes: {$requiredElementsAttributesString}. {$missingElementsAttributesString} is missing.";
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }

    private function getRequiredElementsAttributesString(array $requiredElementsAttributes): string
    {
        switch (count($requiredElementsAttributes)) {
            case 0:
                throw new InvalidArgumentException('At least one required attribute must be informed.');
            case 1:
                return $requiredElementsAttributes[0];

            default:
                $lastRequiredElementAttribute = array_pop($requiredElementsAttributes);

                return implode(', ', $requiredElementsAttributes) . ' and ' . $lastRequiredElementAttribute;
        }
    }

    private function getMissingElementsAttributesString(array $missingElementsAttributes): string
    {
        switch (count($missingElementsAttributes)) {
            case 0:
                throw new InvalidArgumentException('At least one missing required attribute must be informed.');
            case 1:
                return $missingElementsAttributes[0];

            default:
                $lastMissingElementAttribute = array_pop($missingElementsAttributes);

                return implode(', ', $missingElementsAttributes) . ' and ' . $lastMissingElementAttribute;
        }
    }
}
