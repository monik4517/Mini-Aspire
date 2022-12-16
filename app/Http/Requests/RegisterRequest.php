<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules(Request $request)
    {
        return [ 
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' =>'required|confirmed|min:6|max:20',
            'password_confirmation' => 'required|min:6|max:20',
            'roles' => 'required|in:admin,customer'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], config('constants.validation_codes.unprocessable_entity')));
    }

}
