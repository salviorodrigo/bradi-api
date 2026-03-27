<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Enum;

enum PrimitiveType: string
{
    case ARRAY = 'array';
    case BOOLEAN = 'boolean';
    case DOUBLE = 'double';
    case FLOAT = 'float';
    case INTEGER = 'integer';
    case NULL = 'NULL';
    case OBJECT = 'object';
    case STRING = 'string';
}
