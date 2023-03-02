<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateThreadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subject' => 'required|string|min:4|max:255',
            'user_id' => 'required|int'
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
