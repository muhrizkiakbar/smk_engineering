<?php

namespace App\Http\Requests\Telemetries\Api;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'phone_number' => [
                'required','string', 'max:20'
            ],
            'ph' => [ 'nullable','numeric' ],
            'tds' => [ 'nullable','numeric' ],
            'tss' => [ 'nullable','numeric' ],
            'debit' => [ 'nullable','numeric' ],
            'rainfall' => [ 'nullable','numeric' ],
            'water_height' => [ 'nullable','numeric' ],
            'temperature' => [ 'nullable','numeric' ],
            'humidity' => [ 'nullable','numeric' ],
            'wind_direction' => [ 'nullable','numeric' ],
            'wind_speed' => [ 'nullable','numeric' ],
            'solar_radiation' => [ 'nullable','numeric' ],
            'evaporation' => [ 'nullable','numeric' ],
            'dissolve_oxygen' => [ 'nullable','numeric' ],
            'created_at' => ['required','string']
        ];
    }
}
