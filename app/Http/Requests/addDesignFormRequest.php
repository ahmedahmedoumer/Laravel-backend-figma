<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
class addDesignFormRequest extends FormRequest
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
            'designTitle'=>'required',
            'image'=>'required|image',
            'zipfile' => [
                'required',
                'file',
                function ($attribute, $value, $fail) {
                    $zip = new \ZipArchive();
                    if ($zip->open($value) !== true) {
                        $fail('Invalid zip file.');
                    }
                    $zip->close();
                }
            ],
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'status' => 'validation error',
            'errors' => $validator->errors()
        ], 422);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
