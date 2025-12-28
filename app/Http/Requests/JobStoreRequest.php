<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'budget'      => ['required', 'integer', 'min:0'],

            // Kategorija mora postojati u tabeli "categories"
            'category_id' => ['required', 'integer', 'exists:categories,id'],

            // Nemoj forsirati user_id iz forme (controller treba da koristi auth()->id()).
            // Ako forma ipak šalje, neće praviti problem.
            'user_id'     => ['nullable', 'integer', 'exists:users,id'],
        ];
    }
}
