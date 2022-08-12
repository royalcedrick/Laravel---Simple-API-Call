<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Response as Response;
use Illuminate\Validation\ValidationException;

class SendMessageRequest extends FormRequest
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
            'conversation_id'   => ['required'],
            'message'           => ['required']
        ];
    }

    /**
     * Execute when validation fails
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator,
            Response::json([
                'result'    => 'Failed',
                'error'   => $validator->errors(),
            ], 422));
    }
}
