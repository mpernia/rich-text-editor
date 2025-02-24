<?php

namespace Src\Domain\Contracts\Entities;

interface Entity
{
    public static function new(array $properties): self;
    public function toArray(): array;
}
