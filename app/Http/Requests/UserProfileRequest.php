<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user') ?? $this->user()->id;

        return [
            'name'              => ['sometimes', 'string', 'max:255'],
            'email'             => [
                'sometimes',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'password'          => ['sometimes', 'string', 'min:8', 'confirmed'],
            'avatar'            => ['nullable', 'string'], 
            'bio'               => ['nullable', 'string', 'max:500'],
            'phone_number'      => ['nullable', 'string', 'max:15'],
            'address'           => ['nullable', 'string', 'max:255'],
            'meta_title'        => ['nullable', 'string', 'max:255'],
            'meta_description'  => ['nullable', 'string', 'max:500'],
            'meta_keywords'     => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique'         => 'This email is already taken.',
            'password.confirmed'   => 'Passwords do not match.',
            'role.in'              => 'Invalid role specified.',
        ];
    }
}
