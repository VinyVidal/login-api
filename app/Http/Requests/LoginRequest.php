<?php

namespace App\Http\Requests;

class LoginRequest extends TopLevelRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' =>  ['required', 'min:6'],
        ];
    }
}
