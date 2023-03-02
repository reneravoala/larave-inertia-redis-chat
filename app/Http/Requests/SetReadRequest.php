<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetReadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'thread_id' => 'required|int'
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
