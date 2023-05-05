<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
class planFormRequest extends FormRequest
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
            'planTitle'=>'required',
            'planDescription'=>'required',
            'planPrompt'=>'required'
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
