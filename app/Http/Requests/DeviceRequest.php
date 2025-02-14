<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'name' => [ 'required','string', 'max:255' ],
            'type' => [ 'required','string', 'max:255' ],
            'bought_at' => [ 'nullable','date', 'max:255' ],
            'used_at' => [ 'nullable','date', 'max:255' ],
            'damaged_at' => [ 'nullable','date' ],
            'phone_number' => [
                'required','string','max:14',
                Rule::unique('devices')->where(fn ($query) => $query->where('phone_number', $this->phone_number))
            ],
            'has_ph' => [ 'required','string' ],
            'has_tds' => [ 'required','string' ],
            'has_tss' => [ 'required','string' ],
            'has_velocity' => [ 'required','string' ],
            'has_rainfall' => [ 'required','string' ],
            'has_water_height' => [ 'required','string' ],
            'state' => [ 'nullable', 'string', 'max:255' ],
        ];
    }
}
