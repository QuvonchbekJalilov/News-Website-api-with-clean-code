<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class UserRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ];
    }
}