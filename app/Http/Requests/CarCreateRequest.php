<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'number' => ['required', 'string'],
            'color' => ['required', 'string'],
            'vin_code' => ['required', 'string'],
        ];
    }
}
