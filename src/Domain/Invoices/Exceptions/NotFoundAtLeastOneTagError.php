<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Invoices\Exceptions;

use BradiNfeApi\Domain\Common\Protocols\UnprocessableEntityError;
use BradiNfeApi\Domain\Common\ValueObjects\Detail;
use BradiNfeApi\Domain\Common\ValueObjects\Error;
use BradiNfeApi\Domain\Common\ValueObjects\Input;
use InvalidArgumentException;

final class NotFoundAtLeastOneTagError extends UnprocessableEntityError
{
    public function __construct(string $field, string $source, mixed $input, array $tags)
    {
        $tagsString = $this->formatTags($tags);
        $message = "at least one tag of {$tagsString} is required.";
        $error = new Error(
            $source,
            Input::from($input)->value,
            $message
        );

        parent::__construct(new Detail($field, $error));
    }

    private function formatTags(array $tags): string
    {
        switch (count($tags)) {
            case 0:
                throw new InvalidArgumentException('At least one tag is required.');
            case 1:
                return $tags[0];
            case 2:
                return $tags[0] . ' and ' . $tags[1];
            default:
                $lastTag = array_pop($tags);

                return implode(', ', $tags) . ' or ' . $lastTag;
        }
    }
}
