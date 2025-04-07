<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    public function rules(): array
    {
        $categoryId = $this->route('id');

        return [
            'name'             => ['sometimes', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', 'unique:categories,slug,' . $categoryId],
            'parent_id'        => ['nullable', 'exists:categories,id'],
            'description'      => ['nullable', 'string'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'meta_keywords'    => ['nullable', 'string'],
        ];
    }
}
