<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    // Allows any user to make this request. Set to false if using authentication.
    public function authorize(): bool
    {
        return true;
    }

    // Defines the validation rules for creating a new post.
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }
}