<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

use Log;

class UserRequest extends FormRequest
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

        if ($this->mode === 'create')
        {

            return [
                'user_name' => ['required', 'string', 'max:255'],
                'user_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'sei_kana' => 'nullable|max:20|regex:/^[ァ-ヶー\s　]+$/u',
                'mei_kana' => 'nullable|max:20|regex:/^[ァ-ヶー\s　]+$/u',
            ];

        }
        else
        {

            return [
                'user_name' => ['required', 'string', 'max:255'],
                'user_email' => ['required', 'string', 'email', 'max:255', 'unique:users,user_email,'.$this->user_id.',user_id'],
                'password' => ['nullable', 'string', 'min:8'],
                'sei_kana' => 'nullable|max:20|regex:/^[ァ-ヶー\s　]+$/u',
                'mei_kana' => 'nullable|max:20|regex:/^[ァ-ヶー\s　]+$/u',
            ];

        }

    }

    public function prepareForValidation()
    {

        $data = $this->all();

        if ($data['sei'] == 'null')
        {

            $data['sei'] = null;

        }

        if ($data['mei'] == 'null')
        {

            $data['mei'] = null;

        }

        if ($data['sei_kana'] == 'null')
        {

            $data['sei_kana'] = null;

        }

        if ($data['mei_kana'] == 'null')
        {

            $data['mei_kana'] = null;

        }

        if ($data['tel'] == 'null')
        {

            $data['tel'] = null;

        }

        if ($data['zip'] == 'null')
        {

            $data['zip'] = null;

        }

        if ($data['address_01'] == 'null')
        {

            $data['address_01'] = null;

        }

        if ($data['address_02'] == 'null')
        {

            $data['address_02'] = null;

        }

        $this->replace($data);

    }

    public function withValidator(Validator $validator)
    {

        $validator->after(function ($validator)
        {
        });

    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {

        throw (new ValidationException($validator));

    }

}
