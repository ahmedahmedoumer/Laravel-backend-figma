<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class addTeamMemberRequest extends FormRequest
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
    public function rules(Request $request): array
    {
      
        $id=$this->route()->parameter('id');
        $id= User::find($id) ?  User::find($id)->id : Str::random(5) ;
        return [
            'firstName'=>'required|alpha',
            'lastName'=>'required|alpha',
            'email'=>['required','email',Rule::unique('users')->ignore($id)],
            'phone'=>['required','numeric', Rule::unique('users')->ignore($id)],
            'title'=>'required',
            'status'=>'required',
            'password'=>'required|min:8|max:50',
            'confirmPassword'=>'required|same:password',
        ];
    }
    // heyy ahmed how are you , hope you good, almost i have finished all the endpoints and i will show you tomorrow but i want to ensure something that , how many planners and designners are send request for admin approval

    public function messages()
    {
        return [
            'phone.phone' => 'The phone number must be a valid Ethiopian phone number.',
        ];
    }
        protected  function  failedValidation(Validator $validator)
        {
              $response=new JsonResponse([
                       'status' => 'validation error',
                       'errors' => $validator->errors(),
               ],422);
        return throw  new ValidationException($validator,$response);
            
            }
}
