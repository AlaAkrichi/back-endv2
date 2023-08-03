<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules;

use Illuminate\Foundation\Http\FormRequest;

class storUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "first_name" => ["required", "string", "max:255"],
            "last_name" => ["required", "string", "max:255"],
            "date_of_birth" => ["required", 'date'],
            "email" => ["required", "email"],
            "password" => ["required", "confirmed", Rules\Password::defaults()],


        ];
    }
}
