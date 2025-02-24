<?php

namespace Src\Domain\Entities;

use InvalidArgumentException;
use Src\Domain\Contracts\Entities\Entity;
use Src\Domain\Contracts\Entities\User;

readonly class UserEntity implements Entity, User
{
    public function __construct(
        public ?int $id = null,
        public ?string  $name = null,
        public ?string $email = null,
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
            name: $properties['name'],
            email: $properties['email']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
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

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
