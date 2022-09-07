<?php

namespace App\Http\Requests\User;

use App\Http\Requests\TopLevelRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends TopLevelRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['min:3'],
            'email' => ['email', Rule::unique(User::class)->ignore(request()->user)],
            'password' => ['confirmed', 'min:6'],
        ];
    }
}
