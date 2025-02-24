<?php

namespace Src\Infrastructure\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Src\Domain\Entities\PostEntity;

class PostResource extends JsonResource
{
    public function toArray(Request $request)
    {
        /** @var PostEntity $this */
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'summary' => $this->getSummary(),
            'content' => $this->getContent(),
            'status' => $this->getStatus(),
            'status_id' => $this->getStatusId(),
            'user_id' => $this->getUserId(),
        ];
    }
}
