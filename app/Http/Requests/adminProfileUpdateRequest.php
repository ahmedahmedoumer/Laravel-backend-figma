<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;



class adminProfileUpdateRequest extends FormRequest
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
        $userId=Auth::id();
        return [
            'firstName'=>'required|alpha|min:4|max:20',
            'lastName'=>'required|alpha|min:4|max:20',
            'email'=>[ 'required','email', Rule::unique('users','email')->ignore($userId) ],
            'phone'=>'required|phone:+251',
            'title'=>'required',
            'status'=>'required',
            'password'=>'required|min:8|max:50',
            'confirmPassword'=>'required|same:password',
            // 'image' => 'required|image' 
            //
        ];
    }
    public function messages()
    {
        return [
            'phone.phone' => 'The phone number must be a valid Ethiopian phone number.',
        ];
    }
   
 protected function failedValidation(Validator $validator)
    {     
        $response = new JsonResponse([
            'status' => 'validation error',
            'errors' => $validator->errors()
        ], 422);
        throw new ValidationException($validator, $response);
    }
    
}
