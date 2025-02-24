<?php

namespace Src\Application\DataTransferObjects;

use ReflectionClass;

class AbstractDto
{
    protected array $casts = [];


    public function toArray(): array
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();
        $result = [];
        foreach ($properties as $property) {
            $property->setAccessible(true);
            $snakeCaseName = $this->toSnakeCase($property->getName());
            $result[$snakeCaseName] = $property->getValue($this);
        }
        return $result;
    }

    public function excludeFromArray(array $keys): array
    {
        $properties = $this->toArray();
        foreach ($keys as $key) {
            if (array_key_exists($key, $properties)) {
                unset($properties[$key]);
            }
        }
        return $properties;
    }

    public function asQueryParams(string $char = ':', bool $noNulls = false): array
    {
        $result = [];
        foreach ($this->toArray() as $key => $value) {
            if ($value === null && $noNulls) {
                continue;
            }
            $key = sprintf("'%s%s'", $char, $key);
            $result[$key] = $this->wrapToSql($value);
        }
        return $result;
    }

    protected function fill(object|array $properties): void
    {
        if (is_array($properties)) {
            $properties = (object) $properties;
        }
        $reflection = new ReflectionClass($this);

        foreach ($properties as $property => $value) {
            $property = $this->toCamelCase($property);
            if ($reflection->hasProperty($property)) {
                $reflectionProperty = $reflection->getProperty($property);
                if (!$reflectionProperty->isPublic()) {
                    $reflectionProperty->setAccessible(true);
                }
                if (isset($casts[$property])) {
                    $value = $this->casting($casts[$property], $value);
                }
                $reflectionProperty->setValue($this, $value);
            }
        }
    }

    protected function toCamelCase(string $value): string
    {
        return lcfirst(str_replace('_', '', ucwords($value, '_')));
    }

    protected function toSnakeCase(string $value): string
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $value));
    }

    protected function casting(string $cast, string $value): bool|float|int|string
    {
        return match ($cast) {
            'int' => (int) $value,
            'bool' => (bool) $value,
            'float' => (float) $value,
            default => $value,
        };
    }

    protected function wrapToSql(mixed $value): mixed
    {
        $match = is_string($value) ? strtolower($value) : $value;
        if (is_string($match) && in_array($match, ['true', 'false'])) {
            return $match == 'true' ? 1 : 0;
        }
        if (is_string($match)) {
            return sprintf("'%s'", addslashes($value));
        }
        if (is_bool($match)) {
            return (int) $match;
        }
        if (is_int($match)) {
            return (int) $match;
        }
        if (is_float($match)) {
            return (float) $value;
        }
        if (is_null($match)) {
            return 'NULL';
        }
        if (is_array($match)) {
            return implode(
                ',',
                array_map(
                    function ($value) { return is_string($value) ? sprintf("'%s", $value) : $value; },
                    $match
                )
            );
        }
        if (is_object($match)) {
            return json_encode($value, JSON_THROW_ON_ERROR);
        }
        return $value;
    }
}
