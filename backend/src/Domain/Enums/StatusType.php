<?php

namespace Src\Domain\Enums;

enum StatusType: int
{
    case DRAFT = 1;
    case PUBLISHED = 2;
    case PROTECTED = 3;

    public function at(): ?string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PUBLISHED => 'Published',
            self::PROTECTED => 'Protected',
            default => null
        };
    }
}
