<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

use Log;

class CurriculumRequest extends FormRequest
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
            'curriculum_name_admin' => 'required',
            'curriculum_name' => 'required',
            'category_id' => 'required',
            'curriculum_image' => 'nullable|mimes:png,jpg,jpeg,gif',
            'curriculum_type' => 'required',
            'movie_ur' => 'nullable|active_url|starts_with:https://vimeo.com,https://www.vimeo.com,https://youtube.com,https://www.youtube.com',
            'audio_file' => 'nullable|mimes:mp3,mp4',
            'pdf_file1' => 'nullable|mimes:pdf|max:2048',
            'pdf_file2' => 'nullable|mimes:pdf|max:2048',
            'pdf_file3' => 'nullable|mimes:pdf|max:2048',
            'pdf_file4' => 'nullable|mimes:pdf|max:2048',
            'pdf_file5' => 'nullable|mimes:pdf|max:2048',
            'authority_ranks' => 'required',
            'released_date_count' => 'nullable|numeric|gte:0',
            'closed_date_count' => 'nullable|numeric|gte:0',

        ];

    }

    public function withValidator(Validator $validator)
    {

        $validator->after(function ($validator)
        {

            if ($this->input('curriculum_type') == '1')
            {

                if ($this->input('movie_url') == null)
                {

                    $validator->errors()->add('movie_url', __('messages.movie_url_is_required_when_curriculum_type_is_movie'));

                }

            }

            if ($this->input('curriculum_type') == '2')
            {

                $no_audio_file = false;
                if (!$this->has('audio_file'))
                {

                    $no_audio_file = true;

                }

                if ($no_audio_file)
                {

                    if ($this->input('mode') === 'create' ||
                        ($this->input('mode') === 'update' && !$this->has('audio_file_keeping')))
                    {


                        $validator->errors()->add('audio_file', __('messages.audio_file_is_required_when_curriculum_type_is_audio_file'));

                    }

                }

            }

            if ($this->input('curriculum_type') == '3' && $this->input('curriculum_text') == null)
            {

                $validator->errors()->add('curriculum_text', __('messages.curriculum_text_is_required_when_curriculum_type_is_custom'));

            }

            if ($this->input('authority_ranks') != null)
            {

                $authority_ranks = explode(',', $this->input('authority_ranks'));
                if (in_array(0, $authority_ranks) && count($authority_ranks) > 1)
                {

                    $validator->errors()->add('authority_ranks', __('messages.authority_ranks_cannot_set_as_everyone_and_others'));

                }

            }

            if ($this->input('release_type') == '2')
            {

                if ($this->input('released_at') == null)
                {

                    $validator->errors()->add('released_at', __('messages.released_at_is_required_when_release_type_is_unlimited'));

                }

                if ($this->input('closed_at') == null)
                {

                    $validator->errors()->add('closed_at', __('messages.closed_at_is_required_when_release_type_is_unlimited'));

                }

                $released_at = new \DateTime($this->input('released_at'));
                $closed_at = new \DateTime($this->input('closed_at'));
                $now_timestamp = new \DateTime();

                if ($released_at > $closed_at)
                {

                    $validator->errors()->add('closed_at', __('messages.closed_at_is_past_than_released_at'));

                }

            }

            if ($this->input('released_date_count') != null && $this->input('closed_date_count') != null)
            {

                if ($this->input('released_date_count') != 0 && $this->input('released_time') == null)
                {

                    $validator->errors()->add('released_at', __('messages.released_time_is_required'));

                }

                if ($this->input('closed_date_count') != 0 && $this->input('closed_time') == null)
                {

                    $validator->errors()->add('released_at', __('messages.closed_time_is_required'));

                }

                if ($this->input('released_date_count') > $this->input('closed_date_count'))
                {

                    $validator->errors()->add('released_at', __('messages.released_date_count_is_greater_than_closed_date_count'));

                }
                else
                {

                    if ($this->input('released_time') > $this->input('closed_time'))
                    {

                        $validator->errors()->add('released_at', __('messages.released_time_is_future_than_closed_time'));

                    }

                }

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
