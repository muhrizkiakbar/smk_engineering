<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            'visibility_telemetry' => [ 'required','string' ],
            'state' => [ 'nullable', 'string', 'max:255' ],
        ];
    }
}
