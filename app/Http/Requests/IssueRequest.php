<?php

namespace GitScrum\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use GitScrum\Models\Sprint;

class IssueRequest extends FormRequest
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
            'title' => 'required|min:2|max:255',
            'sprint_id' => 'integer',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => trans('gitscrum.issue-cannot-be-blank'),
            'title.min' => trans('gitscrum.issue-must-be-at-least-2-characters'),
            'title.max' => trans('gitscrum.issue-must-be-between-2-and-255-characters'),
            'sprint_id.required' => trans('gitscrum.sprint-cannot-be-blank'),
        ];
    }

    protected function getValidatorInstance()
    {
        $data = $this->all();

        if (isset($data['slug_sprint']) && !empty($data['slug_sprint'])) {
            $data['sprint_id'] = Sprint::slug($data['slug_sprint'])->first()->id;
            unset($data['slug_sprint']);
        }

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
