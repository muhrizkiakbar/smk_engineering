<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RealTelemetryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'device_location_id' => [
                'required','string', 'max:20'
            ],
            'ph' => [ 'nullable','numeric' ],
            'tds' => [ 'nullable','numeric' ],
            'tss' => [ 'nullable','numeric' ],
            'velocity' => [ 'nullable','numeric' ],
            'rainfall' => [ 'nullable','numeric' ],
            'water_height' => [ 'nullable','numeric' ],
            'created_at' => ['nullable'],
        ];
    }
}
