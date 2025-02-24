<?php

namespace Src\Infrastructure\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Src\Domain\Entities\StatusEntity;

class StatusResource extends JsonResource
{
    public function toArray(Request $request)
    {
        /** @var StatusEntity $this */
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}
