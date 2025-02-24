<?php

namespace Src\Infrastructure\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'summary' => ['required', 'string', 'max:300'],
            'content' => ['required', 'string', 'min:3', 'max:3000'],
            'user_id' => ['sometimes', 'integer', 'exists:users,id'],
            'status_id' => ['sometimes','integer', 'exists:statuses,id']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
