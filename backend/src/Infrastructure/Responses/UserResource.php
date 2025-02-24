<?php

namespace Src\Infrastructure\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Src\Domain\Entities\UserEntity;

class UserResource extends JsonResource
{
    public function toArray(Request $request)
    {
        /** @var UserEntity $this */
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}
