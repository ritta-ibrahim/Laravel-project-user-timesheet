<?php

namespace App\Http\Requests;

use App\Enums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string'
            ],
            'last_name' => [
                'required',
                'string'
            ],
            'email' => [
                'required',
                'max:320',
                Rule::unique('users', 'email')
            ],
            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],
        ];
    }
}
