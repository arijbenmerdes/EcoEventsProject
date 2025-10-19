<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_name' => 'required|string|max:255',
            'comment' => 'required|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
        ];
    }

    public function messages(): array
    {
        return [
            'user_name.required' => 'Le nom de l’utilisateur est obligatoire.',
            'comment.required' => 'Le commentaire ne peut pas être vide.',
            'rating.min' => 'La note minimale est 1.',
            'rating.max' => 'La note maximale est 5.',
        ];
    }
}
