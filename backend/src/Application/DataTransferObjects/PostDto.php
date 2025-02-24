<?php

namespace Src\Application\DataTransferObjects;

use Src\Domain\Contracts\DataTransferObject;
use Src\Domain\Enums\StatusType;

class PostDto extends AbstractDto implements DataTransferObject
{
    private ?string $title = null;
    private ?string $summary  = null;
    private ?string $content = null;
    private ?int $userId = null;
    private int $statusId = StatusType::DRAFT->value;

    protected array $casts = [
        'userId' => 'int',
        'statusId' => 'int'
    ];

    public function __construct(object|array $properties)
    {
        $this->fill($properties);
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getStatusId(): int
    {
        return $this->statusId;
    }
}
