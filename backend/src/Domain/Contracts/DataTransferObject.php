<?php

namespace Src\Domain\Contracts;

interface DataTransferObject
{
    public function toArray(): array;
}
