<?php

namespace Src\Application\DataTransferObjects;

use Src\Domain\Contracts\DataTransferObject;

class PdfDto extends AbstractDto implements DataTransferObject
{
    public const FONT_NAME = 'Arial';
    public const FONT_SIZE_TITLE = 16;
    public const FONT_SIZE = 12;
    public const FONT_TYPE_NORMAL = '';
    public const FONT_TYPE_BOLD = 'B';
    public const FONT_TYPE_ITALIC = 'I';
    public const FONT_ALIGN_CENTER = 'C';
    private ?string $title = null;
    private ?string $summary  = null;
    private ?string $content = null;
    private ?string $createAt = null;
    private ?string $updatedAt = null;

    public function __construct(object|array $properties)
    {
        $this->fill($properties);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSummary(): string
    {
        return $this->summary;
    }

    public function getContent(): string
    {
        return $this->content;
    }
    public function getCreateAt(): string
    {
        return $this->createAt;
    }
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
}
