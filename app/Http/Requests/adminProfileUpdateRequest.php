<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'firstName'=>'required|alpha|min:4|max:20',
            'lastName'=>'required|alpha|min4:4|max:20',
            'email'=>'required|email|unique:team_members,email',
            'phone'=>'required|phone:+251',
            'title'=>'required',
            'status'=>'required',
            'password'=>'required|min:8|max:50',
            'confirmPassword'=>'required|same:password',
            'image' => 'required|image',
            //
        ];
    }
}
