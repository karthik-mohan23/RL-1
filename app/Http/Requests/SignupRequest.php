<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // if you explicitly return false from the authorize() method, it means that the user is not authorized to perform the action specified by the request. In such cases, Laravel will automatically abort the request and return a 403 Forbidden HTTP response, indicating that the user does not have permission to perform the requested action.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:55',
            'email' => 'required|email|unique:users,email',
            'password' => 'required','confirmed',Password::min(8)->letters()->symbols()
        ];
    }
}
