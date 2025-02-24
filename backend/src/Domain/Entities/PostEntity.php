<?php

namespace Src\Domain\Entities;

use InvalidArgumentException;
use Src\Domain\Contracts\Entities\Entity;
use Src\Domain\Contracts\Entities\Post;
use Src\Domain\Enums\StatusType;

readonly class PostEntity implements Entity, Post
{
    public function __construct(
        private ?int $id = null,
        private ?string $title = null,
        private ?string $summary  = null,
        private ?string $content = null,
        private ?int $userId  = null,
        private StatusType $status = StatusType::DRAFT
    )
    {

    }

    public static function new(array $properties): self
    {
        if (!isset($properties['title'])) {
            throw new InvalidArgumentException('Title is required.');
        }
        return new self(
            id: $properties['id'],
            title: $properties['title'],
            summary: $properties['summary'],
            content: $properties['content'],
            userId: $properties['user_id'],
            status: StatusType::from($properties['status_id'])
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'content' => $this->content,
            'status' => [
                'id' => $this->status->value,
                'name' => $this->status->name
            ],
            'user_id' => $this->userId,
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
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
        return $this->status->value;
    }

    public function getStatus(): string
    {
        return $this->status->at();
    }
}
