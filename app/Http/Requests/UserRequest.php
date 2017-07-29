<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'cpf' => 'required',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */

    public function messages()
    {
        return [
            'name.required'       => 'Name field is required.',
            'email.required'      => 'E-mail field is required.',
            'email.email'         => 'E-mail field is not a valid e-mail.',
            'phone.required'      => 'Phone field is required.',
            'cpf.required'        => 'CPF field is required.',
        ];
    }
}
