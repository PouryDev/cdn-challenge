<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiftCodeRequest extends FormRequest
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
            'phone_number' => ['required', 'digits:11'],
            'code' => ['required', 'string', 'exists:gift_codes,code'],
            'email' => ['required', 'email'],
        ];
    }
}
