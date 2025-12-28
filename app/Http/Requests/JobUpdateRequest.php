<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobUpdateRequest extends FormRequest
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

            'category_id' => ['required', 'integer', 'exists:categories,id'],

            // Ne forsiraj user_id iz forme — controller treba da koristi auth()->id()
            // (ako forma ipak salje, ovo ce biti validno).
            'user_id'     => ['nullable', 'integer', 'exists:users,id'],
        ];
    }
}
