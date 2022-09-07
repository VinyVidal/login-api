<?php

namespace App\Http\Requests\User;

use App\Http\Requests\TopLevelRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class CreateUserRequest extends TopLevelRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique(User::class)],
            'password' => ['required', 'min:6', 'bail', 'confirmed'],
        ];
    }
}
