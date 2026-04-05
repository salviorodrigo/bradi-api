<?php

declare(strict_types=1);

namespace BradiNfeApi\Domain\Common\Services;

use BradiNfeApi\Domain\Common\ValueObjects\PhpVar;
use InvalidArgumentException;
use ReflectionClass;

final class ClassBuilder
{
    /** @var array<PhpVar> */
    private array $constructorParam = [];

    public function __construct(private readonly string $targetClass)
    {
        if (! class_exists($this->targetClass)) {
            throw new InvalidArgumentException('The provided class does not exist.');
        }

        $params = (new ReflectionClass($this->targetClass))->getConstructor()?->getParameters() ?? [];
        foreach ($params as $param) {
            $type = $param->getType()->getName();
            $this->constructorParam[] = new PhpVar(
                name: $param->getName(),
                type: $type,
                value: $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null
            );
        }

    }

    public function reset(string $targetClass): ClassBuilder
    {
        return new ClassBuilder($targetClass);
    }

    public function withParam(string $name, mixed $value): self
    {
        foreach ($this->constructorParam as $index => $param) {
            if ($param->name === $name) {
                if (gettype($value) !== $param->type) {
                    throw new InvalidArgumentException("The value for parameter '{$name}' must be of type {$param->type}.");
                }
                $this->constructorParam[$index]->value = $value;

                return $this;
            }
        }

        throw new InvalidArgumentException("Parameter '{$name}' not found in the class constructor.");
    }

    /** @return object object must be an instance of the target class */
    public function build(): object
    {
        foreach ($this->constructorParam as $param) {
            $missingParams = array_filter($this->constructorParam, fn (PhpVar $param) => $param->value === null);
            if (! empty($missingParams)) {
                $missingParamNames = array_map(fn (PhpVar $param) => $param->name, $missingParams);
                switch (count($missingParamNames)) {
                    case 1:
                        $message = 'Missing required parameter: ' . $missingParamNames[0] . '.';
                        break;
                    case 2:
                        $message = 'Missing required parameters: ' . implode(' and ', $missingParamNames) . '.';
                        break;
                    default:
                        $message = 'Missing required parameters: ' . implode(', ', array_slice($missingParamNames, 0, -1)) . ', and ' . end($missingParamNames) . '.';
                }

                throw new InvalidArgumentException($message);
            }
        }

        $params = array_reduce(
            $this->constructorParam,
            fn (array $carry, PhpVar $var) => array_merge($carry, [$var->name => $var->value]),
            []
        );

        return new $this->targetClass(...$params);
    }
}
