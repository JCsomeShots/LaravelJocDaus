<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // return [
        //     'nickname' => ['nullable','string','max:8','unique:users'],
        //     'email' => ['required','string','email','max:255','unique:users'],
        //     'password' => ['required','string','confirmed','min:8'],
        // ];
    }

    public function messages()
    {
        return [
            'nickname.max' => 'el nickname no puede tener más de 8 caracteres'
        ];
    }
}
