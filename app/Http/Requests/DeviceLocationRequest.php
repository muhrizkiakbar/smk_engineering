<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DeviceLocationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'device_id' => [
                'required','string', 'max:20'
            ],
            'location_id' => [ 'required','string', 'max:20' ],
            'longitude' => [ 'required','string', 'max:255' ],
            'latitude' => [ 'required','string', 'max:255' ],
            'state' => [ 'nullable', 'string', 'max:255' ],
            'device_id' => 'unique:device_locations,device_id,NULL,id,location_id,' . $this->location_id,
            'location_id' => 'unique:device_locations,location_id,NULL,id,device_id,' . $this->device_id,
        ];
    }
}
