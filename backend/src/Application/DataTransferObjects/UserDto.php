<?php

namespace Src\Application\DataTransferObjects;

use Src\Domain\Contracts\DataTransferObject;

class UserDto extends AbstractDto implements DataTransferObject
{
    private ?string  $name = null;
    private ?string $email = null;

    public function __construct(object|array $properties)
    {
        $this->fill($properties);
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
