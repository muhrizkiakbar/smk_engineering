<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DevicePhotoRequest extends FormRequest
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
            'photo' => 'required|file|mimetypes:image/jpeg,image/png,image/jpg|max:2048',
        ];
    }
}
