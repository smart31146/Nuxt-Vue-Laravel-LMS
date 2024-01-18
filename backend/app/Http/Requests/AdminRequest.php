<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

use Log;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
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
                'admin_name' => ['required', 'string', 'max:255'],
                'admin_email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
                'password' => ['required', 'string', 'min:8'],
                'start_date' => ['required'],
            ];

        }
        else
        {

            return [
                'admin_name' => ['required', 'string', 'max:255'],
                'admin_email' => ['required', 'string', 'email', 'max:255', 'unique:admins,admin_email,'.$this->admin_id.',admin_id'],
                'password' => ['nullable', 'string', 'min:8'],
                'start_date' => ['required'],
            ];

        }

    }

    public function prepareForValidation()
    {

        $data = $this->all();

        if ($data['end_date'] == 'null')
        {

            $data['end_date'] = null;

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
