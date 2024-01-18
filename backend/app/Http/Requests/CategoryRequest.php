<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

use Log;

class CategoryRequest extends FormRequest
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
            'category_name_admin' => 'required',
            'category_name' => 'required',
            'category_level' => 'required',
            'category_image' => 'nullable|mimes:png,jpg,jpeg,gif',
            'category_text' => 'required',
        ];

    }

    public function withValidator(Validator $validator)
    {

        $validator->after(function ($validator)
        {

            if ($this->input('category_level') == 'C' && !$this->has('parent_id'))
            {

                $validator->errors()->add('parent_id', __('messages.parent_category_is_required_when_category_level_is_C'));

            }

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
