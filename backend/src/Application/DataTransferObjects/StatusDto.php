<?php

namespace Src\Application\DataTransferObjects;

use Src\Domain\Contracts\DataTransferObject;

class StatusDto extends AbstractDto implements DataTransferObject
{
    private ?string $name = null;

    public function __construct(object|array $properties)
    {
        $this->fill($properties);
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
