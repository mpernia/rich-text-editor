<?php

namespace Src\Domain\Entities;

use InvalidArgumentException;
use Src\Domain\Contracts\Entities\{Entity, Status};

readonly class StatusEntity implements Entity, Status
{
    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
    )
    {

    }

    public static function new(array $properties): self
    {
        if (!isset($properties['name'])) {
            throw new InvalidArgumentException('Name is required.');
        }
        return new self(
            id: $properties['id'],
            name: $properties['name']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
