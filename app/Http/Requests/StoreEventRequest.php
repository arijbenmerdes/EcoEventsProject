<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Autoriser tout utilisateur authentifié ou pas selon ton besoin
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'participants_count' => 'nullable|integer|min:0',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'preferred_categories' => 'nullable|array',
            'preferred_categories.*' => 'string',
            'preferred_location' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre de l’événement est obligatoire.',
            'start_date.required' => 'La date de début est obligatoire.',
            'end_date.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début.',
        ];
    }
}
